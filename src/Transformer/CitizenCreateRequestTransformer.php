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
        $psw = $this->tokenService->genAuthToken($payload['email'], $payload['password']['value']);

        return [
            'email' => $payload['email'],
            'name' => $payload['name'],
            'password' => $psw,
            'sex' => $payload['sex'],
            'phone' => $payload['phone'],
            'age' => $payload['age'],
        ];
    }
}
