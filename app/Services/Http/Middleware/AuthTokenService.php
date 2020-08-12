<?php

namespace App\Services\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthTokenService
{
    const TOKEN_STARTS_WITH = 'Bearer ';

    public function check(Request $request): bool
    {
        $token = $this->getToken($request);
        if (!$token) {
            return false;
        }

        return $token === config('auth.api_token');
    }

    /**
     * Get the bearer token from the request headers.
     *
     * @param Request $request
     * @return string|false
     */
    private function getToken(Request $request)
    {
        $header = $request->header('Authorization', '');
        if (Str::startsWith($header, self::TOKEN_STARTS_WITH)) {
            return Str::substr($header, Str::length(self::TOKEN_STARTS_WITH));
        }

        return false;
    }
}
