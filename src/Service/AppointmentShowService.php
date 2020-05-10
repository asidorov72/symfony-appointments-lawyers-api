<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7.5.2020 г.
 * Time: 18:51
 */

namespace App\Service;

use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class AppointmentShowService
{
    private $params;

    private $appointmentRepository;

    private $monologLogger;

    public function __construct(
        AppointmentRepository $appointmentRepository,
        LoggerInterface $monologLogger,
        ParameterBagInterface $params
    )
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->monologLogger         = $monologLogger;
        $this->params                = $params;
    }

    public function show(int $page = 1) : JsonResponse
    {
        $itemsPerPage = $this->params->get('appointments_per_page');
        $offset       = ($itemsPerPage * $page) - $itemsPerPage;

        try {
            $appointmentList = $this->appointmentRepository->findAllByOffset(
                [
                    'orderBy' => ['field' => 'id', 'order' => 'asc'],
                    'offset' => $offset,
                    'limit' => $itemsPerPage
                ]
            );

            $this->monologLogger->info('Citizens list were loaded successfully');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if (empty($appointmentList)) {
            $this->monologLogger->error('Nothing was found.');

            return new JsonResponse(['errorMessage' => 'Nothing was found.'], Response::HTTP_BAD_REQUEST);
        }

        $data = [];

        foreach ($appointmentList as $appointment) {
            $data[] = [
                'id' => $appointment->getId(),
                'lawyerId' => $appointment->getLawyerId(),
                'citizenId' => $appointment->getCitizenId(),
                'status' => $appointment->getStatus(),
                'appointmentType' => $appointment->getAppointmentType(),
                'appointmentTitle' => $appointment->getAppointmentTitle(),
                'appointmentDesc' => $appointment->getAppointmentDesc(),
                'paymentStatus' => $appointment->getPaymentStatus(),
                'durationMins' => $appointment->getDurationMins(),
                'appointmentDatetime' => $appointment->getAppointmentDatetime(),
                'date' => $appointment->getDate()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
