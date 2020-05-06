<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 14:37
 */

namespace App\Validator\ConstraintValidator;

use App\Validator\ConstraintValidator\AbstractValidator;

class EmailValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const INVALID_EMAIL_MSG = "Email address %s is not valid.";

    public function validate(array $field, $validation) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $allowEmptyValue = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;

        if (empty($fieldValue)) {
            if ($allowEmptyValue === true) {
                return [];
            } else {
                $errors[] = 'Field ' . $fieldName . ' should not be empty.';
            }
        }

        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
            $errors[] = sprintf(self::INVALID_EMAIL_MSG, $fieldValue);
        }

        return $errors;
    }
}