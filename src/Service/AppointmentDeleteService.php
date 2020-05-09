<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 8.5.2020 г.
 * Time: 15:31
 */

namespace App\Service;

use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Validator\AppointmentDeleteRequestValidator;
use App\Transformer\AppointmentDeleteRequestTransformer;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class AppointmentDeleteService
{
    private $params;

    private $appointmentRepository;

    private $appointmentDeleteRequestValidator;

    private $appointmentDeleteRequestTransformer;

    private $monologLogger;

    public function __construct(
        AppointmentRepository $appointmentRepository,
        LoggerInterface $monologLogger,
        ParameterBagInterface $params,
        AppointmentDeleteRequestValidator $appointmentDeleteRequestValidator,
        AppointmentDeleteRequestTransformer $appointmentDeleteRequestTransformer
    )
    {
        $this->appointmentRepository               = $appointmentRepository;
        $this->monologLogger                       = $monologLogger;
        $this->params                              = $params;
        $this->appointmentDeleteRequestValidator   = $appointmentDeleteRequestValidator;
        $this->appointmentDeleteRequestTransformer = $appointmentDeleteRequestTransformer;
    }

    public function delete(Request $request) : JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->appointmentDeleteRequestValidator->validate($payload);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $payload = $this->appointmentDeleteRequestTransformer->transform($payload);

        try {
            $this->appointmentRepository->findAndDelete($payload);

            $this->monologLogger->info('Appointment was successfully deleted.');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'Appointment was successfully deleted.'], Response::HTTP_OK);
    }
}
