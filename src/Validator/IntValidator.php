<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 14:05
 */

namespace App\Validator;

use App\Validator\AbstractValidator;

class IntValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const MIN_INT_VALUE = 0;

    const MAX_INT_VALUE = null;

    const INVALID_INT_TYPE_MSG = "Field %s must be type integer.";

    const MIN_INT_VALUE_MSG = "Field %s must be at least %d.";

    const MAX_INT_VALUE_MSG = "Field %s cannot be bigger than %d.";

    public function validate(array $field, $validation) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $allowEmptyValue = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;
        $minIntValue     = $validation->constraints['min'] ?? self::MIN_INT_VALUE;
        $maxIntValue     = $validation->constraints['max'] ?? self::MAX_INT_VALUE;

        if (empty($fieldValue)) {
            if ($allowEmptyValue === true) {
                return [];
            } else {
                $errors[] = 'Field ' . $fieldName . ' should not be empty.';
            }
        }

        if (!is_int($fieldValue)) {
            $errors[] = sprintf(self::INVALID_INT_TYPE_MSG, $fieldName);
        }

        if ($minIntValue !== null && (int) $fieldValue < $minIntValue) {
            $errors[] = sprintf(self::MIN_INT_VALUE_MSG, $fieldName, $minIntValue);
        }

        if ($maxIntValue !== null && (int) $fieldValue > $maxIntValue) {
            $errors[] = sprintf(self::MAX_INT_VALUE_MSG, $fieldName, $maxIntValue);
        }

        return $errors;
    }
}