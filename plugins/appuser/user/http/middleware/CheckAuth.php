<?php
namespace AppUser\User\Http\Middleware;

use AppUser\User\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Response;

class CheckAuth {
    public function handle(Request $request, Closure $next)
    {
        $user = AuthService::getUserByToken($request);

        if (!$user) {
            return Response::make('Unauthorized', 401);
        }

        return $next($request);
    }
}
