<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 16:45
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\AuthService;
use Psr\Log\LoggerInterface;
use App\Service\LawyerCreateService;
use App\Service\LawyerShowService;

class LawyerController
{
    private $monologLogger;

    private $authService;

    private $lawyerCreateService;

    private $lawyerShowService;

    /**
     * LawyerController constructor.
     * @param LoggerInterface $monologLogger
     * @param AuthService $authService
     * @param LawyerCreateService $lawyerCreateService
     * @param LawyerShowService $lawyerShowService
     */
    public function __construct(
        LoggerInterface $monologLogger,
        AuthService $authService,
        LawyerCreateService $lawyerCreateService,
        LawyerShowService $lawyerShowService
    )
    {
        $this->monologLogger       = $monologLogger;
        $this->authService         = $authService;
        $this->lawyerCreateService = $lawyerCreateService;
        $this->lawyerShowService   = $lawyerShowService;
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

        return $this->lawyerCreateService->create($request);
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

        return  $this->lawyerShowService->show($page);
    }
}
