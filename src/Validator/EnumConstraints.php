<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 13:29
 */

namespace App\Validator;

class EnumConstraints
{
    public $constraints = [
        'enum' => [],
        'allowEmptyValue' => false,
    ];

    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}