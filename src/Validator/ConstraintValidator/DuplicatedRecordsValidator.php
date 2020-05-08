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

    public function validate(array $criteria, EntityRepository $repository, string $fieldName) : array
    {
        $errors = [];

        $res = $repository->findBy($criteria, [], 1);

        if (!empty($res)) {
            $errors[] = sprintf(self::DUPLICATED_RECORDS_MSG, $fieldName);
        }

        return $errors;
    }
}