<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CMSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        // 401 check
        if (! $user)
        {
            throw new ApiException(message: "Request from unauthenticated user is denied.", status: 401);
        }
        // 403 check
        if (! $user->isAdmin() && ! $user->isManager())
            {
                throw new ApiException(message: "Source is closed for current role.", status: 403);
            }

        return $next($request);
    }
}
