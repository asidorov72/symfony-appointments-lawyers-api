<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 17:03
 */

namespace App\Service;

use App\Repository\LawyerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Transformer\LawyerCreateRequestTransformer;
use App\Validator\LawyerCreateRequestValidator;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class LawyerCreateService
{
    private $lawyerRepository;

    private $lawyerCreateRequestValidator;

    private $lawyerCreateRequestTransformer;

    private $monologLogger;

    /**
     * CitizenCreateService constructor.
     * @param LawyerRepository $lawyerRepository
     * @param LawyerCreateRequestValidator $lawyerCreateRequestValidator
     * @param LoggerInterface $monologLogger
     * @param LawyerCreateRequestTransformer $lawyerCreateRequestTransformer
     */
    public function __construct(
        LawyerRepository $lawyerRepository,
        LawyerCreateRequestValidator $lawyerCreateRequestValidator,
        LoggerInterface $monologLogger,
        LawyerCreateRequestTransformer $lawyerCreateRequestTransformer
    )
    {
        $this->lawyerRepository               = $lawyerRepository;
        $this->lawyerCreateRequestValidator   = $lawyerCreateRequestValidator;
        $this->monologLogger                  = $monologLogger;
        $this->lawyerCreateRequestTransformer = $lawyerCreateRequestTransformer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

//        try {
//            $this->lawyerCreateRequestValidator->validate($payload);
//        } catch (\Exception $e) {
//            $this->monologLogger->error($e->getMessage());
//
//            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//        }

        $payload = $this->lawyerCreateRequestTransformer->transform($payload);

        try{
            $this->lawyerRepository->save($payload);
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $this->monologLogger->info('Lawyer was created!');

        return new JsonResponse(['status' => 'Lawyer was created!'], Response::HTTP_CREATED);
    }
}
