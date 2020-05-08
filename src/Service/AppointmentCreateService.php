<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 22:35
 */

namespace App\Service;

use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Transformer\AppointmentCreateRequestTransformer;
use App\Validator\AppointmentCreateRequestValidator;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class AppointmentCreateService
{
    private $appointmentRepository;

    private $appointmentCreateRequestValidator;

    private $appointmentCreateRequestTransformer;

    private $monologLogger;

    public function __construct(
        AppointmentRepository $appointmentRepository,
        LoggerInterface $monologLogger,
        AppointmentCreateRequestValidator $appointmentCreateRequestValidator,
        AppointmentCreateRequestTransformer $appointmentCreateRequestTransformer
    )
    {
        $this->appointmentRepository               = $appointmentRepository;
        $this->monologLogger                       = $monologLogger;
        $this->appointmentCreateRequestValidator   = $appointmentCreateRequestValidator;
        $this->appointmentCreateRequestTransformer = $appointmentCreateRequestTransformer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->appointmentCreateRequestValidator->validate($payload);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $payload = $this->appointmentCreateRequestTransformer->transform($payload);

        try{
            $this->appointmentRepository->save($payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $this->monologLogger->info('Appointment was requested!');

        return new JsonResponse(['status' => 'Appointment was requested!'], Response::HTTP_CREATED);
    }
}