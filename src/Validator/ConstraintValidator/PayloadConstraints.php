<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.5.2020 г.
 * Time: 14:16
 */

namespace App\Validator\ConstraintValidator;

class PayloadConstraints
{
    /**
     * @var array|null
     */
    public $constraints = [];

    /**
     * PayloadConstraints constructor.
     * @param null $constraints
     */
    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}