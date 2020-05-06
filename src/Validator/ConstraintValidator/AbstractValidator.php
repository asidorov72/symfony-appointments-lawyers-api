<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.5.2020 г.
 * Time: 15:49
 */

namespace App\Validator\ConstraintValidator;

use App\Validator\ConstraintValidator\ApiValidatorInterface;

abstract class AbstractValidator implements ApiValidatorInterface
{
    abstract function validate(array $keyValueArray, $validation) : array;
}