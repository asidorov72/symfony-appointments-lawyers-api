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
use App\Service\AppointmentDeleteService;
use App\Service\AppointmentUpdateService;
use App\Service\AppointmentUpdateStatusService;

class AppointmentController
{
    private $monologLogger;

    private $authService;

    private $appointmentCreateService;

    private $appointmentShowService;

    private $appointmentDeleteService;

    private $appointmentUpdateService;

    private $appointmentUpdateStatusService;

    /**
     * AppointmentController constructor.
     * @param LoggerInterface $monologLogger
     * @param AuthService $authService
     * @param AppointmentCreateService $appointmentCreateService
     * @param AppointmentShowService $appointmentShowService
     * @param AppointmentDeleteService $appointmentDeleteService
     * @param AppointmentUpdateService $appointmentUpdateService
     * @param AppointmentUpdateStatusService $appointmentUpdateStatusService
     */
    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService,
        AppointmentCreateService $appointmentCreateService,
        AppointmentShowService $appointmentShowService,
        AppointmentDeleteService $appointmentDeleteService,
        AppointmentUpdateService $appointmentUpdateService,
        AppointmentUpdateStatusService $appointmentUpdateStatusService
    )
    {
        $this->monologLogger                  = $monologLogger;
        $this->authService                    = $authService;
        $this->appointmentCreateService       = $appointmentCreateService;
        $this->appointmentShowService         = $appointmentShowService;
        $this->appointmentDeleteService       = $appointmentDeleteService;
        $this->appointmentUpdateService       = $appointmentUpdateService;
        $this->appointmentUpdateStatusService = $appointmentUpdateStatusService;
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
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

        return  $this->appointmentDeleteService->delete($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(Request $request): JsonResponse
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

        return  $this->appointmentUpdateStatusService->updateStatus($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $this->authService->isAuthorized($request);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return  $this->appointmentUpdateService->update($request);
    }
}
