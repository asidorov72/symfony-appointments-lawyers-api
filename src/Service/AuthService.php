<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 1.5.2020 г.
 * Time: 19:57
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Validator\AuthLoginRequestValidator;
use App\Repository\CitizenRepository;
use App\Service\AuthTokenService;

/**
 * @codeCoverageIgnore
 */
class AuthService
{
    private $params;

    private $monologLogger;

    private $authLoginRequestValidator;

    private $citizenRepozitory;

    private const AUTH_TYPE = [
        'AUTH1' => 'atype_auth1',
        'AUTH2' => 'atype_auth2'
    ];

    private $authTokenService;

    public function __construct(
        ParameterBagInterface $params,
        LoggerInterface $monologLogger,
        AuthLoginRequestValidator $authLoginRequestValidator,
        CitizenRepository $citizenRepozitory,
        AuthTokenService $authTokenService
    )
    {
        $this->params                    = $params;
        $this->monologLogger             = $monologLogger;
        $this->authLoginRequestValidator = $authLoginRequestValidator;
        $this->citizenRepozitory         = $citizenRepozitory;
        $this->authTokenService          = $authTokenService;
    }

    /**
     * @return mixed
     */
    public static function getAuthTypes() : array
    {
        return array_keys(self::AUTH_TYPE);
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function isAuthorized(Request $request)
    {
        $apiKey     = $this->params->get('api_key');
        $basicToken = $request->headers->get('Authorization');

        if (!empty($basicToken)) {
            $headersTokenArr = explode(' ', $basicToken);
            $headersTokenStr = array_pop($headersTokenArr);

            if ($apiKey !== $headersTokenStr) {
                throw new \Exception('Not authorized');
            }
        } else {
            throw new \Exception('Not authorized. Headers incorrect');
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function isLogged(Request $request)
    {
        $headersXAuthToken = $request->headers->get('X-Auth-Token');

        $payload = json_decode($request->getContent(), true);

        if (empty($headersXAuthToken) || empty($payload['email'])) {
            throw new \Exception('Bad request.');
        }

        try {
            $this->isXAuthTokenValid($payload['email'], $headersXAuthToken);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $payload
     * @return mixed
     */
    private function getAuthType(array $payload)
    {
        $aTypeParam = self::AUTH_TYPE[$payload['authType']];

        return $this->params->get($aTypeParam);
    }

    /**
     * @param string $email
     * @return \App\Entity\Citizen
     * @throws \Exception
     */
    private function getCitizen(string $email)
    {
        $res = $this->citizenRepozitory->findBy(['email' => $email], [], 1);

        if (empty($res)) {
            throw new \Exception('Citizen does not exist!');
        }

        return $res[0];
    }

    /**
     * @param $userType
     * @param $payload
     * @return string|string|JsonResponse
     * @throws \Exception
     */
    private function isTokenValid($userType, $payload)
    {
        $citizenPassword = '';

        $basicToken = $this->authTokenService->genBasicToken($payload['email'], $payload['password']['value']);

        switch($userType) {
            case 'citizen':
                $citizenPassword = $this->getCitizen($payload['email'])->getPassword();
                break;
        }

        if ($citizenPassword !== $basicToken) {
            throw new \Exception('Invalid credentials.');
        }

        $xAuthToken = $this->authTokenService->genXAuthToken($payload['email'], $basicToken);

        return $xAuthToken;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function signIn(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        // 1. Validate Login request parameters
        try {
            $this->authLoginRequestValidator->validate($payload);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        // 2. Get authType (citizen/lawyer) to know where to look
        try{
            $userType = $this->getAuthType($payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        // 3. Compare token from db with the one generated of the payload
        try{
            $authToken = $this->isTokenValid($userType, $payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['X-Auth-Token' => $authToken], Response::HTTP_OK);
    }

    /**
     * @param string $email
     * @param string $headersXAuthToken
     * @throws \Exception
     */
    private function isXAuthTokenValid(string $email, string $headersXAuthToken)
    {
        $basicToken = $this->getCitizen($email)->getPassword();

        $xAuthToken = $this->authTokenService->genXAuthToken($email, $basicToken);

        if ($headersXAuthToken !== $xAuthToken) {
            throw new \Exception('Invalid X-Auth-Token.');
        }
    }
}
