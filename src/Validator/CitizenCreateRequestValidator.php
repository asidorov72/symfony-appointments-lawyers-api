<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2.5.2020 г.
 * Time: 13:41
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
    DatetimeConstraints,
    DatetimeValidator
};
use App\Helper\ArrayHelper;

/**
 * @Annotation
 */
class CitizenCreateRequestValidator
{
    private $intValidator;

    private $stringValidator;

    private $emailValidator;

    private $enumValidator;

    private $datetimeValidator;

    public function __construct(
        IntValidator $intValidator,
        StringValidator $stringValidator,
        EmailValidator $emailValidator,
        EnumValidator $enumValidator,
        DatetimeValidator $datetimeValidator
    )
    {
        $this->intValidator      = $intValidator;
        $this->stringValidator   = $stringValidator;
        $this->emailValidator    = $emailValidator;
        $this->enumValidator     = $enumValidator;
        $this->datetimeValidator = $datetimeValidator;
    }

    public function validate(array $array)
    {
        $errors = [];

        // "email" field validation
        $errors[] = $this->emailValidator->validate(
            ['email' => $array['email']],
            new EmailConstraints
        );

        // "password" field validation
        $errors[] = $this->stringValidator->validate(
            ['password' => $array['password']['value']],
            new StringConstraints([
                'min' => 5,
                'max' => 50,
            ])
        );

        // "firstName" field validation
        $errors[] = $this->stringValidator->validate(
            ['firstName' => $array['firstName']],
            new StringConstraints([
                'min' => 2,
                'max' => 50,
            ])
        );

        // "lastName" field validation
        $errors[] = $this->stringValidator->validate(
            ['lastName' => $array['lastName']],
            new StringConstraints([
                'min' => 2,
                'max' => 50,
            ])
        );

        // "phoneNumber" field validation
        $errors[] = $this->stringValidator->validate(
            ['phoneNumber' => $array['phoneNumber']],
            new StringConstraints([
                'min' => 4,
                'max' => 50
            ])
        );

        // "title" field validation
        $errors[] = $this->enumValidator->validate(
            ['title' => $array['title']],
            new EnumConstraints([
                'enum' => ['Mr.', 'Mrs.', 'Ms.'],
            ])
        );

        // "dateOfBirth" field validation
        $errors[] = $this->datetimeValidator->validate(
            ['dateOfBirth' => $array['dateOfBirth']],
            new DatetimeConstraints([
                'format' => 'Y-m-d',
            ])
        );

        // "postalCode" field validation
        $errors[] = $this->stringValidator->validate(
            ['postalCode' => $array['postalCode']],
            new StringConstraints([
                'min' => 4,
                'max' => 10,
                'allowEmptyValue' => true
            ])
        );

        // "postalAddress" field validation
        $errors[] = $this->stringValidator->validate(
            ['postalAddress' => $array['postalAddress']],
            new StringConstraints([
                'min' => 10,
                'max' => 255,
                'allowEmptyValue' => true
            ])
        );

        // "country" field validation
        $errors[] = $this->stringValidator->validate(
            ['country' => $array['country']],
            new StringConstraints([
                'min' => 2,
                'max' => 255,
                'allowEmptyValue' => true
            ])
        );

        $errors = ArrayHelper::flatArray($errors);

        $errorsStr = implode(" ", $errors);

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}
