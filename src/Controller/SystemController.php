<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 1.5.2020 г.
 * Time: 14:08
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

class SystemController
{
    private $monologLogger;

    public function __construct(LoggerInterface $monologLogger)
    {
        $this->monologLogger = $monologLogger;
    }

    public function healthcheck(): JsonResponse
    {
        $this->monologLogger->info('HealthCheck response: ' . Response::HTTP_NO_CONTENT);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
