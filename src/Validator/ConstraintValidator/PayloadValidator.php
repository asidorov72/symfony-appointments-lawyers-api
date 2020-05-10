<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.5.2020 г.
 * Time: 14:17
 */

namespace App\Validator\ConstraintValidator;

class PayloadValidator
{
    const CONSTRAINTS_EMPTY_MSG = "Payload constraints should not be empty.";

    const PAYLOAD_MISSED_ELEMENTS_MSG = "The elements are required: %s.";

    /**
     * @param array $payload
     * @param $validation
     * @return mixed
     * @throws \Exception
     */
    public function validate(array $payload, $validation)
    {
        if (empty($validation->constraints)) {
            throw new \Exception(self::CONSTRAINTS_EMPTY_MSG);
        } else {
            $constraints = (array) $validation->constraints;
            $constraints = array_flip($constraints);
            $diffArray   = [];

            foreach($constraints as $key => $elem) {
                if (!isset($payload[$key])) {
                    $diffArray[] = $key;
                }
            }

            if (!empty($diffArray)) {
                $diffStr = implode(', ', $diffArray);
                throw new \Exception(sprintf(self::PAYLOAD_MISSED_ELEMENTS_MSG, $diffStr));
            }
        }
    }
}