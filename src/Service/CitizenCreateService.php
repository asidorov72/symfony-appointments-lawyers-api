<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2.5.2020 г.
 * Time: 13:35
 */

namespace App\Service;

use App\Repository\CitizenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Transformer\CitizenCreateRequestTransformer;
use App\Validator\CitizenCreateRequestValidator;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class CitizenCreateService
{
    private $citizenRepository;

    private $citizenCreateRequestValidator;

    private $citizenCreateRequestTransformer;

    private $monologLogger;

    /**
     * CitizenCreateService constructor.
     * @param CitizenRepository $citizenRepository
     * @param CitizenCreateRequestValidator $citizenCreateRequestValidator
     * @param LoggerInterface $monologLogger
     * @param CitizenCreateRequestTransformer $citizenCreateRequestTransformer
     */
    public function __construct(
        CitizenRepository $citizenRepository,
        CitizenCreateRequestValidator $citizenCreateRequestValidator,
        LoggerInterface $monologLogger,
        CitizenCreateRequestTransformer $citizenCreateRequestTransformer
    )
    {
        $this->citizenRepository               = $citizenRepository;
        $this->citizenCreateRequestValidator   = $citizenCreateRequestValidator;
        $this->monologLogger                   = $monologLogger;
        $this->citizenCreateRequestTransformer = $citizenCreateRequestTransformer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->citizenCreateRequestValidator->validate($payload);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $payload = $this->citizenCreateRequestTransformer->transform($payload);

        try{
            $this->citizenRepository->save($payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $this->monologLogger->info('Citizen was created!');

        return new JsonResponse(['status' => 'Citizen was created!'], Response::HTTP_CREATED);
    }
}
