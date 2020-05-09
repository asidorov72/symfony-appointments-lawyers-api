<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 9.5.2020 г.
 * Time: 15:44
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
use App\Helper\DateTimeHelper;

/**
 * @Annotation
 */
class AppointmentUpdateRequestValidator
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
        $this->intValidator          = $intValidator;
        $this->stringValidator       = $stringValidator;
        $this->emailValidator        = $emailValidator;
        $this->enumValidator         = $enumValidator;
        $this->datetimeValidator     = $datetimeValidator;
        $this->duplicatedValidator   = $duplicatedValidator;
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * @param array $array
     * @throws \Exception
     */
    public function validate(array $array)
    {
        $errors = [];

        // "Duplicated records" validation
        $errors[] = $this->duplicatedValidator->validate(
            [
                'id' => $array['appointmentId'],
                'email' => $array['email']
            ],
            $this->appointmentRepository,
            'AppointmentId',
            true
        );

        // "citizenId" field validation
        $errors[] = $this->intValidator->validate(
            ['citizenId' => $array['citizenId']],
            new IntConstraints([
                'min' => 1,
                'max' => 99999999999
            ])
        );

        // "lawyerId" field validation
        $errors[] = $this->intValidator->validate(
            ['lawyerId' => $array['lawyerId']],
            new IntConstraints([
                'min' => 1,
                'max' => 99999999999
            ])
        );

        // "status" field validation
        $errors[] = $this->enumValidator->validate(
            ['status' => $array['status']],
            new EnumConstraints([
                'enum' => ['pending', 'approved', 'rejected', 'closed'],
            ])
        );

        // "paymentStatus" field validation
        $errors[] = $this->enumValidator->validate(
            ['paymentStatus' => $array['paymentStatus']],
            new EnumConstraints([
                'enum' => ['free', 'paid', 'pending'],
                'allowEmptyValue' => true
            ])
        );

        // "email" field validation
        $errors[] = $this->emailValidator->validate(
            ['email' => $array['email']],
            new EmailConstraints
        );

        // "appointmentDatetime" field validation
        // 'expTime' => '18:00',
        $errors[] = $this->datetimeValidator->validate(
            ['appointmentDatetime' => $array['appointmentDatetime']],
            new DatetimeConstraints([
                'format' => 'Y-m-d H:i:s',
                'checkIfAvailable' => true,
                'intervalMins' => $array['durationMins'],
                'expTime' => '18:00'
            ])
        );

        // "durationMins" field validation
        $errors[] = $this->intValidator->validate(
            ['durationMins' => $array['durationMins']],
            new IntConstraints([
                'min' => 30,
                'max' => 300
            ])
        );

        // "appointmentTitle" field validation
        $errors[] = $this->stringValidator->validate(
            ['appointmentTitle' => $array['appointmentTitle']],
            new StringConstraints([
                'min' => 10,
                'max' => 255,
                'allowEmptyValue' => true
            ])
        );

        // "appointmentDesc" field validation
        $errors[] = $this->stringValidator->validate(
            ['appointmentDesc' => $array['appointmentDesc']],
            new StringConstraints([
                'min' => 10,
                'max' => 255,
                'allowEmptyValue' => true
            ])
        );

        // "appointmentType" field validation
        $errors[] = $this->stringValidator->validate(
            ['appointmentType' => $array['appointmentType']],
            new StringConstraints([
                'min' => 5,
                'max' => 100,
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
