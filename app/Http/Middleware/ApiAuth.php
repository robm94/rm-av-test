<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearer = $request->bearerToken();
        if (! $bearer) {
            return response()->json('Unauthorized', 401);
        }

        $token = ApiToken::findByToken($bearer);

        //dd($token->expires_at);
        if (!$token || ($token->expires_at && $token->expires_at->isPast())) {
            return response()->json('Unauthorized', 401);
        } 

        return $next($request);
    }
}
