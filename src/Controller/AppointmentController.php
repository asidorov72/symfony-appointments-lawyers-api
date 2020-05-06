<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 22:31
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\AuthService;
use Psr\Log\LoggerInterface;
use App\Service\AppointmentCreateService;
use App\Service\CitizenShowService;

class AppointmentController
{
    private $monologLogger;

    private $authService;

    private $appointmentCreateService;

    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService,
        AppointmentCreateService $appointmentCreateService
    )
    {
        $this->monologLogger            = $monologLogger;
        $this->authService              = $authService;
        $this->appointmentCreateService = $appointmentCreateService;
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->authService->isAuthorized($request);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $this->authService->isLogged($request);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return $this->appointmentCreateService->create($request);
    }

//    public function list(): JsonResponse
//    {
//        return  $this->citizenShowService->show();
//    }
}