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
    /**
     * @var array|null
     */
    public $constraints = [
        'checkIfExpired' => false,
        'checkIfAvailable' => false,
        'intervalMins' => 0,
        'format' => 'Y-m-d H:i:s',
        'TZ' => 'UTC',
        'expTime' => false,
        'setCutoffTime' => false,
        'allowEmptyValue' => false,
    ];

    /**
     * DatetimeConstraints constructor.
     * @param null $constraints
     */
    public function __construct($constraints = null)
    {
        $this->constraints = $constraints
            ??
            $this->constraints;
    }
}