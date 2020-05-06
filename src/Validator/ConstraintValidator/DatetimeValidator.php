<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 11:22
 */

namespace App\Validator\ConstraintValidator;

use App\Validator\ConstraintValidator\AbstractValidator;
use App\Helper\DatetimeHelper;

class DatetimeValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    const INVALID_DATETIME_VALUE_MSG = "Field %s value is invalid.";

    public function validate(array $field, $validation) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $allowEmptyValue  = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;
        $format           = $validation->constraints['format'] ?? self::DATETIME_FORMAT;

        if (empty($fieldValue)) {
            if ($allowEmptyValue === true) {
                return [];
            } else {
                $errors[] = 'Field ' . $fieldName . ' should not be empty.';
            }
        }

        if (DatetimeHelper::validateDate($fieldValue, $format) === false) {
            $errors[] = sprintf(self::INVALID_DATETIME_VALUE_MSG, $fieldName);
        }

        return $errors;
    }
}