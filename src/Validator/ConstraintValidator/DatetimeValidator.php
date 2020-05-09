<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 11:22
 */

namespace App\Validator\ConstraintValidator;

use App\Validator\ConstraintValidator\AbstractValidator;
use App\Helper\DateTimeHelper;

class DatetimeValidator extends AbstractValidator
{
    const ALLOW_EMPTY_VALUE = false;

    const CHECK_IF_DATETIME_EXPIRED = false;

    const CHECK_IF_DATETIME_AVAILABLE = false;

    const DATETIME_INTERVAL_MINS = 0;

    const SET_CUTOFF_TIME = false;

    const EXP_TIME = '18:00';

    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    const DATETIME_TIMEZONE = 'UTC';

    const INVALID_DATETIME_VALUE_MSG = "Field %s value is invalid. Expected format is %s.";

    const DATETIME_UNAVAILABLE_MSG = "The field %s date %s is unavailable. Duration was calculated.";

    const DATETIME_EXPIRED_MSG = "The field %s date %s is expired.";

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

        $allowEmptyValue  = $validation->constraints['allowEmptyValue'] ?? self::ALLOW_EMPTY_VALUE;
        $format           = $validation->constraints['format'] ?? self::DATETIME_FORMAT;
        $timeZone         = $validation->constraints['TZ'] ?? self::DATETIME_TIMEZONE;
        $setCutoffTime    = $validation->constraints['setCuttoffTime'] ?? self::SET_CUTOFF_TIME;
        $checkIfExpired   = $validation->constraints['checkIfExpired'] ?? self::CHECK_IF_DATETIME_EXPIRED;
        $checkIfAvailable = $validation->constraints['checkIfAvailable'] ?? self::CHECK_IF_DATETIME_AVAILABLE;
        $expTime          = $validation->constraints['expTime'] ?? self::EXP_TIME;
        $intervalMins     = $validation->constraints['intervalMins'] ?? self::DATETIME_INTERVAL_MINS;

        if (empty($fieldValue)) {
            if ($allowEmptyValue === true) {
                return [];
            } else {
                $errors[] = 'Field ' . $fieldName . ' should not be empty.';
            }
        }

        if (DateTimeHelper::validateDate($fieldValue, $format) === false) {
            $errors[] = sprintf(self::INVALID_DATETIME_VALUE_MSG, $fieldName, $format);
        } else {

            if ($checkIfExpired === true
                && DateTimeHelper::isDatetimeExpired($fieldValue, $format, 'UTC', $setCutoffTime) === true) {
                $errors[] = sprintf(self::DATETIME_EXPIRED_MSG, $fieldName, $fieldValue);
            }

            if ($checkIfAvailable === true) {
                $isDatetimeUnavailable = DateTimeHelper::isDatetimeUnavailable(
                    $fieldValue,
                    $format,
                    $timeZone,
                    'TODAY',
                    $expTime,
                    $intervalMins
                );

                if ($isDatetimeUnavailable === true) {
                    $errors[] = sprintf(self::DATETIME_UNAVAILABLE_MSG, $fieldName, $fieldValue);
                }
            }
        }

        return $errors;
    }
}