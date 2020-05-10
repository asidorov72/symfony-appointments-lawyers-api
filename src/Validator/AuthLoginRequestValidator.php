<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 13:12
 */

namespace App\Validator;

use App\Validator\ConstraintValidator\{
    StringConstraints,
    StringValidator,
    IntConstraints,
    IntValidator,
    EmailConstraints,
    EmailValidator,
    EnumConstraints,
    EnumValidator,
    PayloadConstraints,
    PayloadValidator
};
use App\Service\AuthService;
use App\Helper\ArrayHelper;

/**
 * @Annotation
 */
class AuthLoginRequestValidator
{
    private $intValidator;

    private $stringValidator;

    private $emailValidator;

    private $enumValidator;

    private $payloadValidator;

    /**
     * AuthLoginRequestValidator constructor.
     * @param IntValidator $intValidator
     * @param StringValidator $stringValidator
     * @param EmailValidator $emailValidator
     * @param EnumValidator $enumValidator
     * @param PayloadValidator $payloadValidator
     */
    public function __construct(
        IntValidator $intValidator,
        StringValidator $stringValidator,
        EmailValidator $emailValidator,
        EnumValidator $enumValidator,
        PayloadValidator $payloadValidator
    )
    {
        $this->intValidator     = $intValidator;
        $this->stringValidator  = $stringValidator;
        $this->emailValidator   = $emailValidator;
        $this->enumValidator    = $enumValidator;
        $this->payloadValidator = $payloadValidator;
    }

    public function validate(array $array)
    {
        $errors = [];

        $this->payloadValidator->validate(
            $array,
            new PayloadConstraints([
                'email',
                'password',
                'authType'
            ])
        );

        // "email" field validation
        $errors[] = $this->emailValidator->validate(
            ['email' => $array['email']],
            new EmailConstraints
        );

        // "password" field validation
        $errors[] = $this->stringValidator->validate(
            ['password' => $array['password']],
            new StringConstraints([
                'min' => 5,
                'max' => 50,
            ])
        );

        // "name" field validation
        $errors[] = $this->enumValidator->validate(
            ['authType' => $array['authType']],
            new EnumConstraints([
                'enum' => AuthService::getAuthTypes(),
                'showHints' => false
            ])
        );

        $errors = ArrayHelper::flatArray($errors);

        $errorsStr = implode(" ", $errors);

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}