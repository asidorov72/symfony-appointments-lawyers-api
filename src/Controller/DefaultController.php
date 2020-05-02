<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 1.5.2020 г.
 * Time: 14:45
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class DefaultController
{
    public function __construct(LoggerInterface $monologLogger)
    {
        $this->monologLogger = $monologLogger;
    }

    public function index(): Response
    {
        $this->monologLogger->error('Index page response: ' . Response::HTTP_NOT_FOUND);

        return new Response(null, Response::HTTP_NOT_FOUND);
    }
}
