<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 8.5.2020 г.
 * Time: 15:54
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;

class AppointmentDeleteRequestTransformer extends AbstractTransformer
{
    /**
     * @param array $payload
     * @return mixed
     */
    public function transform(array $payload) : array
    {
        return [
            'id' => $payload['appointmentId'],
        ];
    }
}
