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
use App\Service\AppointmentShowService;

class AppointmentController
{
    private $monologLogger;

    private $authService;

    private $appointmentCreateService;

    private $appointmentShowService;

    /**
     * AppointmentController constructor.
     * @param LoggerInterface $monologLogger
     * @param AuthService $authService
     * @param AppointmentCreateService $appointmentCreateService
     * @param AppointmentShowService $appointmentShowService
     */
    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService,
        AppointmentCreateService $appointmentCreateService,
        AppointmentShowService $appointmentShowService
    )
    {
        $this->monologLogger            = $monologLogger;
        $this->authService              = $authService;
        $this->appointmentCreateService = $appointmentCreateService;
        $this->appointmentShowService   = $appointmentShowService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function list(Request $request, $page): JsonResponse
    {
        try {
            $this->authService->isAuthorized($request);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return  $this->appointmentShowService->show($page);
    }
}