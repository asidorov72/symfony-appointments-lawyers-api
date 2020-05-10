<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 9.5.2020 г.
 * Time: 14:25
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;

class AppointmentUpdateStatusRequestTransformer extends AbstractTransformer
{
    /**
     * @param array $payload
     * @return mixed
     */
    public function transform(array $payload) : array
    {
        return [
            'id' => $payload['appointmentId'],
            'paymentStatus' => $payload['paymentStatus'],
            'status' => $payload['status']
        ];
    }
}
