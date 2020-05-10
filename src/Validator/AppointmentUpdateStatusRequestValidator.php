<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 9.5.2020 г.
 * Time: 14:19
 */

namespace App\Validator;

use App\Validator\ConstraintValidator\{
    IntConstraints,
    IntValidator,
    EnumConstraints,
    EnumValidator,
    DuplicatedRecordsValidator,
    PayloadConstraints,
    PayloadValidator
};
use App\Repository\AppointmentRepository;
use App\Helper\ArrayHelper;

/**
 * @Annotation
 */
class AppointmentUpdateStatusRequestValidator
{
    private $intValidator;

    private $enumValidator;

    private $duplicatedValidator;

    private $appointmentRepository;

    private $payloadValidator;

    /**
     * AppointmentUpdateStatusRequestValidator constructor.
     * @param EnumValidator $enumValidator
     * @param DuplicatedRecordsValidator $duplicatedValidator
     * @param IntValidator $intValidator
     * @param AppointmentRepository $appointmentRepository
     * @param PayloadValidator $payloadValidator
     */
    public function __construct(
        EnumValidator $enumValidator,
        DuplicatedRecordsValidator $duplicatedValidator,
        IntValidator $intValidator,
        AppointmentRepository $appointmentRepository,
        PayloadValidator $payloadValidator
    )
    {
        $this->enumValidator         = $enumValidator;
        $this->intValidator          = $intValidator;
        $this->duplicatedValidator   = $duplicatedValidator;
        $this->appointmentRepository = $appointmentRepository;
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
                'appointmentId',
                'paymentStatus',
                'status'
            ])
        );

        // "Duplicated records" validation
        $errors[] = $this->duplicatedValidator->validate(
            [
                'id' => $array['appointmentId'],
            ],
            $this->appointmentRepository,
            'AppointmentId',
            true
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

        $errors = ArrayHelper::flatArray($errors);

        $errorsStr = implode(" ", $errors);

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}
