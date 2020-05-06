<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 14:12
 */

namespace App\Validator\ConstraintValidator;

class IntConstraints
{
    const NUMERIC_MIN_VALUE = 0;

    const NUMERIC_MAX_VALUE = 100;

    public $constraints = [
        'min' => self::NUMERIC_MIN_VALUE,
        'max' => self::NUMERIC_MAX_VALUE,
        'allowEmptyValue' => false,
    ];

    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}