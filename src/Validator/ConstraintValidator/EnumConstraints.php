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
    /**
     * @var array|null
     */
    public $constraints = [
        'enum' => [],
        'showHints' => true,
        'allowEmptyValue' => false,
    ];

    /**
     * EnumConstraints constructor.
     * @param null $constraints
     */
    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}