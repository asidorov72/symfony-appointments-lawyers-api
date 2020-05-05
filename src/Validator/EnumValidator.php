<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 13:30
 */

namespace App\Validator;

use App\Validator\AbstractValidator;

class EnumValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const INVALID_ENUM_VALUE_MSG = "Field %s value is invalid.";

    const INVALID_ENUM_TYPE_MSG = "Field %s type is invalid.";

    public function validate(array $field, $validation) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $allowEmptyValue = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;
        $enumArrayValue  = $validation->constraints['enum'] ?? [];

        if (empty($fieldValue)) {
            if ($allowEmptyValue === true) {
                return [];
            } else {
                $errors[] = 'Field ' . $fieldName . ' should not be empty.';
            }
        }

        if (!is_array($enumArrayValue) || empty($enumArrayValue)) {
            $errors[] = sprintf(self::INVALID_ENUM_TYPE_MSG, $fieldName);
        }

        if (!in_array($fieldValue, $enumArrayValue)) {
            $errors[] = sprintf(self::INVALID_ENUM_VALUE_MSG, $fieldName);
        }

        return $errors;
    }
}