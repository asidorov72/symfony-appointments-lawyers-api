<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7.5.2020 г.
 * Time: 21:16
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
    DatetimeValidator,
    DuplicatedRecordsValidator
};
use App\Repository\AppointmentRepository;
use App\Helper\ArrayHelper;

/**
 * @Annotation
 */
class AppointmentCreateRequestValidator
{
    private $intValidator;

    private $stringValidator;

    private $emailValidator;

    private $enumValidator;

    private $datetimeValidator;

    private $duplicatedValidator;

    private $appointmentRepository;

    /**
     * LawyerCreateRequestValidator constructor.
     * @param IntValidator $intValidator
     * @param StringValidator $stringValidator
     * @param EmailValidator $emailValidator
     * @param EnumValidator $enumValidator
     * @param DatetimeValidator $datetimeValidator
     * @param DuplicatedRecordsValidator $duplicatedValidator
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(
        IntValidator $intValidator,
        StringValidator $stringValidator,
        EmailValidator $emailValidator,
        EnumValidator $enumValidator,
        DatetimeValidator $datetimeValidator,
        DuplicatedRecordsValidator $duplicatedValidator,
        AppointmentRepository $appointmentRepository
    )
    {
        $this->intValidator        = $intValidator;
        $this->stringValidator     = $stringValidator;
        $this->emailValidator      = $emailValidator;
        $this->enumValidator       = $enumValidator;
        $this->datetimeValidator   = $datetimeValidator;
        $this->duplicatedValidator = $duplicatedValidator;
        $this->appointmentRepository    = $appointmentRepository;
    }

    /**
     * @param array $array
     * @throws \Exception
     */
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
                'max' => 10
            ])
        );

        // "postalAddress" field validation
        $errors[] = $this->stringValidator->validate(
            ['postalAddress' => $array['postalAddress']],
            new StringConstraints([
                'min' => 10,
                'max' => 255
            ])
        );

        // "country" field validation
        $errors[] = $this->stringValidator->validate(
            ['country' => $array['country']],
            new StringConstraints([
                'min' => 2,
                'max' => 100
            ])
        );

        // "companyName" field validation
        $errors[] = $this->stringValidator->validate(
            ['companyName' => $array['companyName']],
            new StringConstraints([
                'min' => 2,
                'max' => 100,
                'allowEmptyValue' => true
            ])
        );

        // "lawyerLicenseNumber" field validation
        $errors[] = $this->stringValidator->validate(
            ['lawyerLicenseNumber' => $array['lawyerLicenseNumber']],
            new StringConstraints([
                'min' => 3,
                'max' => 50
            ])
        );

        // "lawyerLicenseIssueDate" field validation
        $errors[] = $this->datetimeValidator->validate(
            ['lawyerLicenseIssueDate' => $array['lawyerLicenseIssueDate']],
            new DatetimeConstraints([
                'format' => 'Y-m-d',
            ])
        );

        // "lawyerLicenseExpireDate" field validation
        $errors[] = $this->datetimeValidator->validate(
            ['lawyerLicenseExpireDate' => $array['lawyerLicenseExpireDate']],
            new DatetimeConstraints([
                'checkIfExpired' => true,
                'format' => 'Y-m-d',
            ])
        );

        // "lawyerLicenseName" field validation
        $errors[] = $this->stringValidator->validate(
            ['lawyerLicenseName' => $array['lawyerLicenseName']],
            new StringConstraints([
                'min' => 2,
                'max' => 100,
                'allowEmptyValue' => true
            ])
        );

        // "lawyerDegree" field validation
        $errors[] = $this->stringValidator->validate(
            ['lawyerDegree' => $array['lawyerDegree']],
            new StringConstraints([
                'min' => 2,
                'max' => 50
            ])
        );

        // "typeOfLawyer" field validation
        $errors[] = $this->stringValidator->validate(
            ['typeOfLawyer' => $array['typeOfLawyer']],
            new StringConstraints([
                'min' => 2,
                'max' => 50
            ])
        );

        $errors = ArrayHelper::flatArray($errors);

        $errorsStr = implode(" ", $errors);

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}
