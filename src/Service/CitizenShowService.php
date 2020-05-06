<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 19:23
 */

namespace App\Service;

use App\Repository\CitizenRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class CitizenShowService
{
    private $citizenRepository;

    private $monologLogger;

    public function __construct(
        CitizenRepository $citizenRepository,
        LoggerInterface $monologLogger
    )
    {
        $this->citizenRepository = $citizenRepository;
        $this->monologLogger      = $monologLogger;
    }

    public function show() : JsonResponse
    {
        try {
            $citizenList = $this->citizenRepository->findAllCitizen(
                [
                    'orderBy' => ['order' => 'desc'],
                  //  'limit' => 10
                ]
            );

            $this->monologLogger->info('Citizens list were loaded successfully');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if (empty($citizenList)) {
            $this->monologLogger->error('Nothing was found.');

            return new JsonResponse(['errorMessage' => 'Nothing was found.'], Response::HTTP_BAD_REQUEST);
        }

        $data = [];

        foreach ($citizenList as $citizen) {
            $data[] = [
                'id' => $citizen->getId(),
                'email' => $citizen->getEmail(),
                'name' => $citizen->getName(),
                'password' => $citizen->getPassword(),
                'phone' => $citizen->getPhone(),
                'sex' => $citizen->getSex(),
                'age' => $citizen->getAge(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
