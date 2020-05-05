<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.5.2020 г.
 * Time: 16:17
 */

namespace App\Service;

/**
 * @codeCoverageIgnore
 */
class AuthTokenService
{
    public function genAuthToken($username, $password): string
    {
        return base64_encode($username . ':' . $password);
    }
}
