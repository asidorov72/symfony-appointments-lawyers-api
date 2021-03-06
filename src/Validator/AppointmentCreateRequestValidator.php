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
    EnumConstraints,
    EnumValidator,
    DatetimeConstraints,
    DatetimeValidator,
    DuplicatedRecordsValidator,
    PayloadConstraints,
    PayloadValidator
};
use App\Repository\AppointmentRepository;
use App\Repository\CitizenRepository;
use App\Helper\ArrayHelper;
use App\Helper\DateTimeHelper;

/**
 * @Annotation
 */
class AppointmentCreateRequestValidator
{
    private $intValidator;

    private $stringValidator;

    private $enumValidator;

    private $datetimeValidator;

    private $duplicatedValidator;

    private $appointmentRepository;

    private $citizenRepository;

    private $payloadValidator;

    /**
     * AppointmentCreateRequestValidator constructor.
     * @param IntValidator $intValidator
     * @param StringValidator $stringValidator
     * @param EnumValidator $enumValidator
     * @param DatetimeValidator $datetimeValidator
     * @param DuplicatedRecordsValidator $duplicatedValidator
     * @param AppointmentRepository $appointmentRepository
     * @param CitizenRepository $citizenRepository
     * @param PayloadValidator $payloadValidator
     */
    public function __construct(
        IntValidator $intValidator,
        StringValidator $stringValidator,
        EnumValidator $enumValidator,
        DatetimeValidator $datetimeValidator,
        DuplicatedRecordsValidator $duplicatedValidator,
        AppointmentRepository $appointmentRepository,
        CitizenRepository $citizenRepository,
        PayloadValidator $payloadValidator
    )
    {
        $this->intValidator          = $intValidator;
        $this->stringValidator       = $stringValidator;
        $this->enumValidator         = $enumValidator;
        $this->datetimeValidator     = $datetimeValidator;
        $this->duplicatedValidator   = $duplicatedValidator;
        $this->appointmentRepository = $appointmentRepository;
        $this->citizenRepository     = $citizenRepository;
        $this->payloadValidator      = $payloadValidator;
    }

    /**
     * @param array $array
     * @throws \Exception
     */
    public function validate(array $array)
    {
        $errors = [];

        $this->payloadValidator->validate(
            $array,
            new PayloadConstraints([
                'lawyerId',
                'citizenId',
                'appointmentDatetime',
                'durationMins',
                'paymentStatus',
                'appointmentDesc',
                'appointmentTitle',
                'appointmentType',
                'status'
            ])
        );

        // "Duplicated records" validation
        $errors[] = $this->duplicatedValidator->validate(
            [
                'appointmentDatetime' => DateTimeHelper::createFromFormatValidation(
                    $array['appointmentDatetime'],
                    'Y-m-d H:i:s'
                ),
                'citizenId' => (int) $array['citizenId'],
                'lawyerId' => (int) $array['lawyerId']
            ],
            $this->appointmentRepository,
            'AppointmentDatetime'
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
