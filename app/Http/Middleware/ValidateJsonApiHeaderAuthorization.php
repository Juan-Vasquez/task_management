<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateJsonApiHeaderAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ( empty($request->header('authorization')) ){
            throw new HttpException(401, __('The authorization header must be present'));
        }

        try {

            JWTAuth::parseToken()->authenticate();

        } catch (TokenExpiredException $e) {
            
            throw new HttpException(401, __('Token expired'));

        } catch (TokenInvalidException $e) {

            throw new HttpException(401, __('Invalid token'));

        } catch (JWTException $e) {

            throw new HttpException(401, __('Token absent'));

        }

        return $next($request);
    }
}
