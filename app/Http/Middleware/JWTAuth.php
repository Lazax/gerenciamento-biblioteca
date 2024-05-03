<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Symfony\Component\HttpFoundation\Response;

class JWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if(!$request->hasHeader('Authorization')) throw new \Exception();

            $date = new Carbon();
            $currentDate = $date->getTimestamp();
            $payload = AuthController::getPayload();

            if(
                $currentDate >= $payload->tokenInfo->nbt 
                && $currentDate < $payload->tokenInfo->exp
            ) return $next($request);

            throw new \Exception();
        } catch (\Exception $e) {
            return response()->json('', 401);
        }
    }
}
