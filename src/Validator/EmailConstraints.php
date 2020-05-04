<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 14:35
 */

namespace App\Validator;

class EmailConstraints
{
    public $constraints = [
        'allowEmptyValue' => false,
    ];

    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}