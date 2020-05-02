<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 1.5.2020 г.
 * Time: 19:57
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @codeCoverageIgnore
 */
class AuthService
{
    private $params;

    private $monologLogger;

    public function __construct(
        ParameterBagInterface $params,
        LoggerInterface $monologLogger
    )
    {
        $this->params        = $params;
        $this->monologLogger = $monologLogger;
    }

    public function check(Request $request)
    {
        $authToken  = $this->params->get('auth_token');
        $basicToken = $request->headers->get('Authorization');

        if (!empty($basicToken)) {
            $headersTokenArr = explode(' ', $basicToken);
            $headersTokenStr = array_pop($headersTokenArr);

            if ($authToken !== $headersTokenStr) {
                throw new \Exception('Not authorized');
            }
        } else {
            throw new \Exception('Not authorized. Headers incorrect');
        }
    }
}
