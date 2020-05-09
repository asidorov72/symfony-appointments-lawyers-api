<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.5.2020 г.
 * Time: 14:35
 */

namespace App\Validator\ConstraintValidator;

class EmailConstraints
{
    /**
     * @var array|null
     */
    public $constraints = [
        'allowEmptyValue' => false,
    ];

    /**
     * EmailConstraints constructor.
     * @param null $constraints
     */
    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}