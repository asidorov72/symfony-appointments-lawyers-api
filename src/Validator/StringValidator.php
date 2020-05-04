<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 11:47
 */

namespace App\Validator;

use App\Validator\AbstractValidator;

class StringValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const MIN_STRING_LENGTH = 2;

    const MAX_STRING_LENGTH = 100;

    const INVALID_STRING_TYPE_MSG = "Field %s must be type string.";

    const MIN_STRING_LEN_MSG = "Field %s must be at least %d characters.";

    const MAX_STRING_LEN_MSG = "Field %s cannot be longer than %d characters.";

    public function validate(array $field, $validation) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $allowEmptyValue  = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;
        $minStringLength  = $validation->constraints['min'] ?? self::MIN_STRING_LENGTH;
        $maxStringLength  = $validation->constraints['max'] ?? self::MAX_STRING_LENGTH;

        if (empty($fieldValue)) {
            if ($allowEmptyValue === true) {
                return [];
            } else {
                $errors[] = 'Field ' . $fieldName . ' should not be empty.';
            }
        }

        if (!is_string($fieldValue)) {
            $errors[] = sprintf(self::INVALID_STRING_TYPE_MSG, $fieldName);
        }

        if (strlen($fieldValue) < $minStringLength) {
            $errors[] = sprintf(self::MIN_STRING_LEN_MSG, $fieldName, $minStringLength);
        }

        if (strlen($fieldValue) > $maxStringLength) {
            $errors[] = sprintf(self::MAX_STRING_LEN_MSG, $fieldName, $maxStringLength);
        }

        return $errors;
    }
}