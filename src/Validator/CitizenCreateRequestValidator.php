<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2.5.2020 г.
 * Time: 13:41
 */

namespace App\Validator;

use App\Validator\{
    StringConstraints,
    StringValidator,
    IntConstraints,
    IntValidator,
    EmailConstraints,
    EmailValidator
};

/**
 * @Annotation
 */
class CitizenCreateRequestValidator
{
    private $intValidator;

    private $stringValidator;

    private $emailValidator;

    public function __construct(
        IntValidator $intValidator,
        StringValidator $stringValidator,
        EmailValidator $emailValidator
    )
    {
        $this->intValidator    = $intValidator;
        $this->stringValidator = $stringValidator;
        $this->emailValidator  = $emailValidator;
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
        $nameErrors = $this->stringValidator->validate(
            ['name' => $array['name']],
            new StringConstraints([
                'min' => 2,
                'max' => 50,
            ])
        );

        // "phone" field validation
        $phoneErrors = $this->stringValidator->validate(
            ['phone' => $array['phone']],
            new StringConstraints([
                'min' => 4,
                'max' => 50,
                'allowEmptyValue' => true
            ])
        );

        // "sex" field validation
        $sexErrors = $this->stringValidator->validate(
            ['sex' => $array['sex']],
            new StringConstraints([
                'min' => 2,
                'max' => 50,
                'allowEmptyValue' => true
            ])
        );

        // "age" field validation
        $ageErrors = $this->intValidator->validate(
            ['age' => $array['age']],
            new IntConstraints([
                'min' => 18,
                'max' => 99,
                'allowEmptyValue' => true
            ])
        );

        $errorsStr = implode(" ", array_merge(
            $emailErrors,
            $nameErrors,
            $ageErrors,
            $passwordErrors,
            $phoneErrors,
            $sexErrors
        ));

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}
