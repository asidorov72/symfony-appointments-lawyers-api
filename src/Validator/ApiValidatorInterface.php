<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.5.2020 г.
 * Time: 15:43
 */

namespace App\Validator;

interface ApiValidatorInterface
{
    public function validate(array $keyValueArray, $validation) : array;
}