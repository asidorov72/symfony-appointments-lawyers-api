<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 10:55
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\AuthService;
use Psr\Log\LoggerInterface;


class AuthController
{
    private $monologLogger;

    private $authService;

    private $citizenCreateService;

    private $citizenShowService;

    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService
    )
    {
        $this->monologLogger = $monologLogger;
        $this->authService   = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $this->authService->isAuthorized($request);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return $this->authService->signIn($request);
    }



    public function list(): JsonResponse
    {
        return  $this->citizenShowService->show();
    }
}
