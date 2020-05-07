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
use App\Service\CitizenCreateService;
use App\Service\CitizenShowService;

class CitizenController
{
    private $monologLogger;

    private $authService;

    private $citizenCreateService;

    private $citizenShowService;

    /**
     * CitizenController constructor.
     * @param LoggerInterface $monologLogger
     * @param AuthService $authService
     * @param CitizenCreateService $citizenCreateService
     * @param CitizenShowService $citizenShowService
     */
    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService,
        CitizenCreateService $citizenCreateService,
        CitizenShowService $citizenShowService
    )
    {
        $this->monologLogger        = $monologLogger;
        $this->authService          = $authService;
        $this->citizenCreateService = $citizenCreateService;
        $this->citizenShowService   = $citizenShowService;
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

        return $this->citizenCreateService->create($request);
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

        return  $this->citizenShowService->show($page);
    }
}
