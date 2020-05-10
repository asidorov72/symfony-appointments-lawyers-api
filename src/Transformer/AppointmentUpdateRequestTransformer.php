<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 9.5.2020 г.
 * Time: 15:35
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;

class AppointmentUpdateRequestTransformer extends AbstractTransformer
{
    /**
     * @param array $payload
     * @return mixed
     */
    public function transform(array $payload) : array
    {
        $appointmentDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $payload['appointmentDatetime']);

        return [
            'id' => $payload['appointmentId'],
            'lawyerId' => (int) $payload['lawyerId'],
            'citizenId' => (int) $payload['citizenId'],
            'appointmentDatetime' => $appointmentDatetime,
            'durationMins' => $payload['durationMins'],
            'paymentStatus' => $payload['paymentStatus'],
            'appointmentDesc' => $payload['appointmentDesc'],
            'appointmentTitle' => $payload['appointmentTitle'],
            'appointmentType' => $payload['appointmentType'],
            'status' => $payload['status']
        ];
    }
}
