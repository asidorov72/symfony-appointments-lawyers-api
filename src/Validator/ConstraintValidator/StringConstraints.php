<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 11:09
 */

namespace App\Validator\ConstraintValidator;

class StringConstraints
{
    const STRING_MIN_LENGTH = 2;

    const STRING_MAX_LENGTH = 255;

    public $constraints = [
            'min' => self::STRING_MIN_LENGTH,
            'max' => self::STRING_MAX_LENGTH,
            'allowEmptyValue' => false,
        ];

    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}
