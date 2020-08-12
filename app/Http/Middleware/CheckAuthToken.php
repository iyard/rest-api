<?php

namespace App\Http\Middleware;

use App\Services\Http\Middleware\AuthTokenService;
use Closure;

class CheckAuthToken
{
    /**
     * @var AuthTokenService
     */
    private $service;

    public function __construct(AuthTokenService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->service->check($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
