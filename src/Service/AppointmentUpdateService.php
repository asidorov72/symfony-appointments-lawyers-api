<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 9.5.2020 г.
 * Time: 15:28
 */

namespace App\Service;

use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Transformer\AppointmentUpdateRequestTransformer;
use App\Validator\AppointmentUpdateRequestValidator;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class AppointmentUpdateService
{
    private $appointmentRepository;

    private $appointmentUpdateRequestValidator;

    private $appointmentUpdateRequestTransformer;

    private $monologLogger;

    public function __construct(
        AppointmentRepository $appointmentRepository,
        LoggerInterface $monologLogger,
        AppointmentUpdateRequestValidator $appointmentUpdateRequestValidator,
        AppointmentUpdateRequestTransformer $appointmentUpdateRequestTransformer
    )
    {
        $this->appointmentRepository               = $appointmentRepository;
        $this->monologLogger                       = $monologLogger;
        $this->appointmentUpdateRequestValidator   = $appointmentUpdateRequestValidator;
        $this->appointmentUpdateRequestTransformer = $appointmentUpdateRequestTransformer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->appointmentUpdateRequestValidator->validate($payload);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $payload = $this->appointmentUpdateRequestTransformer->transform($payload);

        try{
            $this->appointmentRepository->update($payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $this->monologLogger->info('Appointment was modified!');

        return new JsonResponse(['status' => 'Appointment was modified!'], Response::HTTP_CREATED);
    }
}