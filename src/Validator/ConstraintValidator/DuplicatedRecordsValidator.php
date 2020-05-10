<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7.5.2020 г.
 * Time: 12:19
 */

namespace App\Validator\ConstraintValidator;

use Doctrine\ORM\EntityRepository;

class DuplicatedRecordsValidator
{
    const DUPLICATED_RECORDS_MSG = "%s already reserved.";

    const REQUESTED_RECORDS_MSG = "Record with this %s was not found.";

    public function validate(
        array $criteria,
        EntityRepository $repository,
        string $fieldName,
        bool $inverse = null
    ) : array
    {
        $errors = [];

        $res = $repository->findBy($criteria, [], 1);

        if (empty($inverse) && !empty($res)) {
            $errors[] = sprintf(self::DUPLICATED_RECORDS_MSG, $fieldName);
        } elseif(!empty($inverse) && empty($res)) {
            $errors[] = sprintf(self::REQUESTED_RECORDS_MSG, $fieldName);
        }

        return $errors;
    }
}