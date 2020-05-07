<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 19:23
 */

namespace App\Service;

use App\Repository\CitizenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class CitizenShowService
{
    private $params;

    private $citizenRepository;

    private $monologLogger;

    public function __construct(
        CitizenRepository $citizenRepository,
        LoggerInterface $monologLogger,
        ParameterBagInterface $params
    )
    {
        $this->citizenRepository = $citizenRepository;
        $this->monologLogger     = $monologLogger;
        $this->params            = $params;
    }

    public function show(int $page = 1) : JsonResponse
    {
        $itemsPerPage = $this->params->get('citizens_per_page');
        $offset       = ($itemsPerPage * $page) - $itemsPerPage;

        try {
            $citizenList = $this->citizenRepository->findAllByOffset(
                [
                    'orderBy' => ['field' => 'id', 'order' => 'asc'],
                    'offset' => $offset,
                    'limit' => $itemsPerPage
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
                'firstName' => $citizen->getFirstName(),
                'lastName' => $citizen->getLastName(),
                'password' => $citizen->getPassword(),
                'phoneNumber' => $citizen->getPhoneNumber(),
                'title' => $citizen->getTitle(),
                'dateOfBirth' => $citizen->getDateOfBirth(),
                'country' => $citizen->getCountry(),
                'postalCode' => $citizen->getPostalCode(),
                'postalAddress' => $citizen->getPostalAddress()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
