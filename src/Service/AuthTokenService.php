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
    private const X_AUTH_TOKEN_LEN = 34;

    // Basic token
    public function genBasicToken($username, $password): string
    {
        return base64_encode($username . ':' . $password);
    }

    // X-Auth-Token
    public function genXAuthToken(string $email, string $basicToken, string $userType): string
    {
        $prefix = strtoupper($userType) . '_';

        return $prefix . substr(base64_encode($email . ':' . $basicToken), 0, self::X_AUTH_TOKEN_LEN);
    }
}
