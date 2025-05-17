<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class verifytoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $token = $request->token;
            if($token){
                $user = JWTAuth::parseToken()->authenticate();
            }
        }catch(\Exception $e){
            if($e instanceof TokenInvalidException){
                return response()->json(['msg'=>'invalid token']);
            }
            if($e instanceof TokenExpiredException){
                return response()->json(['msg'=>'expired token']);
            }
            else
                return response()->json(['msg'=>'another token']);
        }
        return $next($request);
    }
}
