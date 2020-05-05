<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 13:12
 */

namespace App\Validator;

use App\Validator\{
    StringConstraints,
    StringValidator,
    IntConstraints,
    IntValidator,
    EmailConstraints,
    EmailValidator,
    EnumConstraints,
    EnumValidator
};
use App\Service\AuthService;

/**
 * @Annotation
 */
class AuthLoginRequestValidator
{
    private $intValidator;

    private $stringValidator;

    private $emailValidator;

    private $enumValidator;

    public function __construct(
        IntValidator $intValidator,
        StringValidator $stringValidator,
        EmailValidator $emailValidator,
        EnumValidator $enumValidator
    )
    {
        $this->intValidator    = $intValidator;
        $this->stringValidator = $stringValidator;
        $this->emailValidator  = $emailValidator;
        $this->enumValidator   = $enumValidator;
    }

    public function validate(array $array)
    {
        // "email" field validation
        $emailErrors = $this->emailValidator->validate(
            ['email' => $array['email']],
            new EmailConstraints
        );

        // "password" field validation
        $passwordErrors = $this->stringValidator->validate(
            ['password' => $array['password']['value']],
            new StringConstraints([
                'min' => 5,
                'max' => 50,
            ])
        );

        // "name" field validation
        $authTypeErrors = $this->enumValidator->validate(
            ['authType' => $array['authType']],
            new EnumConstraints([
                'enum' => AuthService::getAuthTypes()
            ])
        );

        $errorsStr = implode(" ", array_merge(
            $emailErrors,
            $passwordErrors,
            $authTypeErrors
        ));

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}