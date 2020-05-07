<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7.5.2020 г.
 * Time: 12:19
 */

namespace App\Validator\ConstraintValidator;

use App\Validator\ConstraintValidator\AbstractValidator;

class DuplicatedRecordsValidator extends AbstractValidator
{
    const DUPLICATED_RECORDS_MSG = "%s already exists.";

    public function validate(array $field, $repository) : array
    {
        $errors = [];

        $fieldName  = key($field);
        $fieldValue = $field[$fieldName];

        $res = $repository->findBy([$fieldName => $fieldValue], [], 1);

        if (!empty($res)) {
            $errors[] = sprintf(self::DUPLICATED_RECORDS_MSG, $fieldValue);
        }

        return $errors;
    }
}