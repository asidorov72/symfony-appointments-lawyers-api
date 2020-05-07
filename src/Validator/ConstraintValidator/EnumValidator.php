<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 13:30
 */

namespace App\Validator\ConstraintValidator;

use App\Validator\ConstraintValidator\AbstractValidator;

class EnumValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const SHOW_HINTS = true;

    const INVALID_ENUM_VALUE_MSG = "Field %s value is invalid.";

    const INVALID_ENUM_VALUE_MSG_SHOW_HINTS = "Field %s value is invalid. See possible values: %s.";

    const INVALID_ENUM_TYPE_MSG = "Field %s type is invalid.";

    /**
     * @param array $field
     * @param $validation
     * @return mixed
     */
    public function validate(array $field, $validation) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $allowEmptyValue = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;
        $enumArrayValue  = $validation->constraints['enum'] ?? [];
        $showHints       = $validation->constraints['showHints'] ?? self::SHOW_HINTS;

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
            if ($showHints === true) {
                $fieldValueStr = implode(", ", $enumArrayValue);
                $errors[] = sprintf(self::INVALID_ENUM_VALUE_MSG_SHOW_HINTS, $fieldName, $fieldValueStr);
            } else {
                $errors[] = sprintf(self::INVALID_ENUM_VALUE_MSG, $fieldName);
            }
        }

        return $errors;
    }
}