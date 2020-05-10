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
use App\Repository\LawyerRepository;
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

    private $lawyerRepozitory;

    private const AUTH_TYPE = [
        'AUTH1' => 'atype_auth1',
        'AUTH2' => 'atype_auth2'
    ];

    private $authTokenService;

    /**
     * AuthService constructor.
     * @param ParameterBagInterface $params
     * @param LoggerInterface $monologLogger
     * @param AuthLoginRequestValidator $authLoginRequestValidator
     * @param CitizenRepository $citizenRepozitory
     * @param LawyerRepository $lawyerRepozitory
     * @param \App\Service\AuthTokenService $authTokenService
     */
    public function __construct(
        ParameterBagInterface $params,
        LoggerInterface $monologLogger,
        AuthLoginRequestValidator $authLoginRequestValidator,
        CitizenRepository $citizenRepozitory,
        LawyerRepository $lawyerRepozitory,
        AuthTokenService $authTokenService
    )
    {
        $this->params                    = $params;
        $this->monologLogger             = $monologLogger;
        $this->authLoginRequestValidator = $authLoginRequestValidator;
        $this->citizenRepozitory         = $citizenRepozitory;
        $this->lawyerRepozitory          = $lawyerRepozitory;
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
                throw new \Exception('Not authorized.');
            }
        } else {
            throw new \Exception('Not authorized. Invalid headers.');
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function isLogged(Request $request)
    {
        $xAuthToken = $request->headers->get('X-Auth-Token');

        if (!empty($xAuthToken)) {
            $uuidToken = $this->authTokenService->getXAuthToken($xAuthToken);

            if ($xAuthToken !== $uuidToken) {
                throw new \Exception('Not authenticated.');
            }
        } else {
            throw new \Exception('Not authenticated. Invalid headers.');
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
     * @param string $userType
     * @return mixed
     * @throws \Exception
     */
    private function getLawyerCitizen(string $email, string $userType)
    {
        switch($userType) {
            case 'citizen':
                $res = $this->citizenRepozitory->findBy(['email' => $email], [], 1);
                break;
            case 'lawyer':
                $res = $this->lawyerRepozitory->findBy(['email' => $email], [], 1);
                break;
        }

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
        $basicToken = $this->authTokenService->createBasicToken($payload['email'], $payload['password']['value']);

        $savedPassword = $this->getLawyerCitizen($payload['email'], $userType)->getPassword();

        if ($savedPassword !== $basicToken) {
            throw new \Exception('Invalid credentials.');
        }

        return $this->authTokenService->createXAuthToken();
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

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        // 2. Get authType (citizen/lawyer) to know where to look
        try{
            $userType = $this->getAuthType($payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        // 3. Compare token from db with the one generated of the payload
        try{
            $authToken = $this->isTokenValid($userType, $payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(['X-Auth-Token' => $authToken], Response::HTTP_OK);
    }

    public function signOut(Request $request)
    {
        $xAuthToken = $request->headers->get('X-Auth-Token');

        try{
            $this->authTokenService->deleteXAuthToken($xAuthToken);

            $this->monologLogger->info('X-Auth-Token was successfully deleted.');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
