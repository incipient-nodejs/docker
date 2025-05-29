<?php

namespace App\Http\Middleware;

use Closure;
USE Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class apiTokenApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->headers->get('x_token_tudokabir');
            if(!isset($token)) throw new Exception("Token not found");
            if($token != env('API_SECRET')) throw new Exception("Not valid token");
        } catch (Exception $e) {;
            return response()->json($e->getMessage(), 404);
        }
        return $next($request);
    }
}
