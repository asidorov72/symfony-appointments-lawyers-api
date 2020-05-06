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

    public function __construct(AuthTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function transform(array $payload) : array
    {
        $password = $this->tokenService->genBasicToken(
            $payload['email'],
            $payload['password']['value']
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
