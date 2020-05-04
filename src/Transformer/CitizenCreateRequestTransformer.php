<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2.5.2020 г.
 * Time: 20:51
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;

class CitizenCreateRequestTransformer extends AbstractTransformer
{
    public function transform(array $payload) : array
    {
        return [
            'email' => $payload['email'],
            'name' => $payload['name'],
            'password' => $payload['password']['value'],
            'sex' => $payload['sex'],
            'phone' => $payload['phone'],
            'age' => $payload['age'],
        ];
    }
}
