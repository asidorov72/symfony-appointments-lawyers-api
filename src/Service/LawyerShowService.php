<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 17:04
 */

namespace App\Service;

use App\Repository\LawyerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class LawyerShowService
{
    private $lawyerRepository;

    private $monologLogger;

    public function __construct(
        LawyerRepository $lawyerRepository,
        LoggerInterface $monologLogger
    )
    {
        $this->lawyerRepository = $lawyerRepository;
        $this->monologLogger    = $monologLogger;
    }

    public function show() : JsonResponse
    {
        try {
            $lawyerList = $this->lawyerRepository->findAllCitizen(
                [
                    'orderBy' => ['order' => 'desc'],
                    //  'limit' => 10
                ]
            );

            $this->monologLogger->info('Lawyers list were loaded successfully');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if (empty($lawyerList)) {
            $this->monologLogger->error('Nothing was found.');

            return new JsonResponse(['errorMessage' => 'Nothing was found.'], Response::HTTP_BAD_REQUEST);
        }

        $data = [];

        foreach ($lawyerList as $lawyer) {
            $data[] = [
                'id' => $lawyer->getId(),
                'email' => $lawyer->getEmail(),
                'firstName' => $lawyer->getFirstName(),
                'lastName' => $lawyer->getLastName(),
                'password' => $lawyer->getPassword(),
                'phoneNumber' => $lawyer->getPhoneNumber(),
                'title' => $lawyer->getTitle(),
                'dateOfBirth' => $lawyer->getDateOfBirth(),
                'country' => $lawyer->getCountry(),
                'postalCode' => $lawyer->getPostalCode(),
                'postalAddress' => $lawyer->getPostalAddress(),
                'companyName' => $lawyer->getCompanyName(),
                'lawyerLicenseNumber' => $lawyer->getLawyerLicenseNumber(),
                'lawyerLicenseIssueDate' => $lawyer->getLawyerLicenseIssueDate(),
                'lawyerLicenseExpireDate' => $lawyer->getLawyerLicenseExpireDate(),
                'lawyerLicenseName' => $lawyer->getLawyerLicenseName(),
                'lawyerDegree' => $lawyer->getLawyerDegree(),
                'typeOfLawyer' => $lawyer->getTypeOfLawyer()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
