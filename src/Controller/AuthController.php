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
use Psr\Log\LoggerInterface;
use App\Service\AuthService;


class AuthController
{
    private $monologLogger;

    private $authService;

    /**
     * AuthController constructor.
     * @param LoggerInterface $monologLogger
     * @param AuthService $authService
     */
    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService
    )
    {
        $this->monologLogger = $monologLogger;
        $this->authService   = $authService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
}
