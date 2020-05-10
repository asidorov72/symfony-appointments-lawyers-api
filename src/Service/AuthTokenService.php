<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 16:17
 */

namespace App\Service;

use App\Repository\TokenRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore
 */
class AuthTokenService
{
    private $tokenRepository;

    private $monologLogger;

    public function __construct(
        TokenRepository $tokenRepository,
        LoggerInterface $monologLogger
    )
    {
        $this->tokenRepository = $tokenRepository;
        $this->monologLogger   = $monologLogger;
    }

    /**
     * @param $username
     * @param $password
     * @return string
     */
    public function createBasicToken($username, $password): string
    {
        return base64_encode($username . ':' . $password);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function createXAuthToken(): string
    {
        $uuid = uuid_create(UUID_TYPE_RANDOM);

        $this->tokenRepository->save(['uuidToken' => $uuid]);

        return $uuid;
    }

    /**
     * @param string $uuidToken
     * @return string
     */
    public function getXAuthToken(string $uuidToken): ?string
    {
        $tokenEntity = $this->tokenRepository->findUuidToken($uuidToken);

        if (!empty($tokenEntity)) {
            return $tokenEntity->getUuidToken();
        }
        return $tokenEntity;
    }

    public function deleteXAuthToken(string $uuidToken): ?string
    {
        try {
            $tokenEntity = $this->tokenRepository->findAndDelete(['uuidToken' => $uuidToken]);

            $this->monologLogger->info('X-Auth-Token was successfully deleted.');

            return true;
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


}
