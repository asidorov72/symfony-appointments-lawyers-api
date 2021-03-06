<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2.5.2020 г.
 * Time: 20:51
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;
use App\Service\AuthTokenService;

class CitizenCreateRequestTransformer extends AbstractTransformer
{
    private $tokenService;

    /**
     * CitizenCreateRequestTransformer constructor.
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

        $dateOfBirth = \DateTime::createFromFormat('Y-m-d', $payload['dateOfBirth']);

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
        ];
    }
}
