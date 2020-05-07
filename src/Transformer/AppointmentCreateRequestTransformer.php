<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7.5.2020 г.
 * Time: 19:53
 */

namespace App\Transformer;

use App\Transformer\AbstractTransformer;
use App\Service\AuthTokenService;
use App\Helper\DateTimeHelper;

class AppointmentCreateRequestTransformer extends AbstractTransformer
{
    private $tokenService;

    /**
     * AppointmentCreateRequestTransformer constructor.
     * @param AuthTokenService $tokenService
     */
    public function __construct(AuthTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function transform(array $payload) : array
    {
        $datetimeStr         = DateTimeHelper::getCurrentDatetime();
        $date                = \DateTime::createFromFormat('Y-m-d H:i:s', $datetimeStr);
        $appointmentDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $payload['datetime']);

        return [
            'date' => $date,
            'email' => $payload['email'],
            'lawyerId' => (int) $payload['lawyerId'],
            'citizenId' => (int) $payload['citizenId'],
            'datetime' => $appointmentDatetime,
            'duration' => $payload['duration'],
            'paymentStatus' => $payload['paymentStatus'],
            'meetingDescription' => $payload['meetingDescription'],
            'meetingTitle' => $payload['meetingTitle'],
            'meetingType' => $payload['meetingType'],
            'status' => $payload['status']
        ];
    }
}
