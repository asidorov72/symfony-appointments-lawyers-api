<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 13:29
 */

namespace App\Validator\ConstraintValidator;

class EnumConstraints
{
    public $constraints = [
        'enum' => [],
        'showHints' => true,
        'allowEmptyValue' => false,
    ];

    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}