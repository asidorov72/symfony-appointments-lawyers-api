<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 1.5.2020 г.
 * Time: 14:08
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\AuthService;
use Psr\Log\LoggerInterface;

class UserController
{
    private $monologLogger;

    private $authService;

    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService
    )
    {
        $this->monologLogger = $monologLogger;
        $this->authService   = $authService;
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->authService->check($request);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }



        $payload = json_decode($request->getContent(), true);

        return new JsonResponse(['message' => 'Go ahead!!'], Response::HTTP_CREATED);

        //return $this->feedbackCreateService->create($payload);
    }
}
