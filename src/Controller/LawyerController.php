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

    public function list(): JsonResponse
    {
        return  $this->lowyerShowService->show();
    }
}
