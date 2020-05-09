<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 9.5.2020 г.
 * Time: 14:25
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;
use App\Helper\DateTimeHelper;

class AppointmentUpdateStatusRequestTransformer extends AbstractTransformer
{
    /**
     * @param array $payload
     * @return mixed
     */
    public function transform(array $payload) : array
    {
        $datetimeStr         = DateTimeHelper::getCurrentDatetime();
        $date                = \DateTime::createFromFormat('Y-m-d H:i:s', $datetimeStr);

        return [
            'id' => $payload['appointmentId'],
            'date' => $date,
            'paymentStatus' => $payload['paymentStatus'],
            'status' => $payload['status']
        ];
    }
}
