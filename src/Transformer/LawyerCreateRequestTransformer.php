<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 17:36
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;
use App\Service\AuthTokenService;

class LawyerCreateRequestTransformer extends AbstractTransformer
{
    private $tokenService;

    /**
     * LawyerCreateRequestTransformer constructor.
     * @param AuthTokenService $tokenService
     */
    public function __construct(AuthTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function transform(array $payload) : array
    {
        $password = $this->tokenService->createBasicToken(
            $payload['email'],
            $payload['password']
        );

        $dateOfBirth       = \DateTime::createFromFormat('Y-m-d', $payload['dateOfBirth']);
        $licenseIssueDate  = \DateTime::createFromFormat('Y-m-d', $payload['lawyerLicenseIssueDate']);
        $licenseExpireDate = \DateTime::createFromFormat('Y-m-d', $payload['lawyerLicenseExpireDate']);

        return [
            'password' => $password,
            'email' => $payload['email'],
            'firstName' => $payload['firstName'],
            'lastName' => $payload['lastName'],
            'phoneNumber' => $payload['phoneNumber'],
            'title' => $payload['title'],
            'postalCode' => $payload['postalCode'],
            'postalAddress' => $payload['postalAddress'],
            'country' => $payload['country'],
            'dateOfBirth' => $dateOfBirth,
            'companyName' => $payload['companyName'],
            'lawyerLicenseNumber' => $payload['lawyerLicenseNumber'],
            'lawyerLicenseIssueDate' => $licenseIssueDate,
            'lawyerLicenseExpireDate' => $licenseExpireDate,
            'lawyerLicenseName' => $payload['lawyerLicenseName'],
            'lawyerDegree' => $payload['lawyerDegree'],
            'typeOfLawyer' => $payload['typeOfLawyer']
        ];
    }
}
