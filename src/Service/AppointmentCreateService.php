<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 22:35
 */

namespace App\Service;

use App\Repository\CitizenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class AppointmentCreateService
{
    private $citizenRepository;

    private $monologLogger;

    public function __construct(
        CitizenRepository $citizenRepository,
        LoggerInterface $monologLogger
    )
    {
        $this->citizenRepository = $citizenRepository;
        $this->monologLogger     = $monologLogger;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        var_dump($payload);
        die();




//        try {
//            $this->citizenCreateRequestValidator->validate($payload);
//        } catch (\Exception $e) {
//            $this->monologLogger->error($e->getMessage());
//
//            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//
//        $payload = $this->citizenCreateRequestTransformer->transform($payload);
//
//        try{
//            $this->citizenRepository->saveCitizen($payload);
//        } catch(\Exception $e) {
//            $this->monologLogger->error($e->getMessage());
//
//            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//
//        $this->monologLogger->info('Citizen was created!');
//
//        return new JsonResponse(['status' => 'Citizen was created!'], Response::HTTP_CREATED);
    }
}