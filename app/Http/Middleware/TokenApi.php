<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class TokenApi
{
    public function handle(Request $request, Closure $next, $ability)
    {
        $user = $request->user();
        if (!$user || ! $user->tokenCan($ability)){
            return response()->json(['mensage' => 'Petición sin autorización '.$ability], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
