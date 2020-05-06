<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 11:22
 */

namespace App\Validator\ConstraintValidator;

class DatetimeConstraints
{
    public $constraints = [
        'format' => 'Y-m-d H:i:s',
        'allowEmptyValue' => false,
    ];

    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}