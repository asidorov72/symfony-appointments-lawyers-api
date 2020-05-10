<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 8.5.2020 г.
 * Time: 15:41
 */

namespace App\Validator;

use App\Validator\ConstraintValidator\{
    IntConstraints,
    IntValidator,
    DuplicatedRecordsValidator,
    PayloadConstraints,
    PayloadValidator
};
use App\Repository\AppointmentRepository;
use App\Helper\ArrayHelper;

/**
 * @Annotation
 */
class AppointmentDeleteRequestValidator
{
    private $intValidator;

    private $duplicatedValidator;

    private $appointmentRepository;

    private $payloadValidator;

    /**
     * AppointmentDeleteRequestValidator constructor.
     * @param \IntValidator $intValidator
     * @param \DuplicatedRecordsValidator $duplicatedValidator
     * @param AppointmentRepository $appointmentRepository
     * @param \PayloadValidator $payloadValidator
     */
    public function __construct(
        IntValidator $intValidator,
        DuplicatedRecordsValidator $duplicatedValidator,
        AppointmentRepository $appointmentRepository,
        PayloadValidator $payloadValidator
    )
    {
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
                'appointmentId'
            ])
        );

        // "Duplicated records" validation
        $errors[] = $this->duplicatedValidator->validate(
            [
                'id' => $array['appointmentId']
            ],
            $this->appointmentRepository,
            'AppointmentId',
            true
        );

        // "id" field validation
        $errors[] = $this->intValidator->validate(
            ['id' => $array['appointmentId']],
            new IntConstraints([
                'min' => 1,
                'max' => 99999999999
            ])
        );

        $errors = ArrayHelper::flatArray($errors);

        $errorsStr = implode(" ", $errors);

        if (!empty($errorsStr)) {
            throw new \Exception($errorsStr);
        }
    }
}
