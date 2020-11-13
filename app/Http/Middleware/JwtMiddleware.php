<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JwtAuth\Exceptions\TokenInvalidException;
use Tymon\JwtAuth\Exceptions\TokenExpiredException;
use Tymon\JwtAuth\Exceptions\JWTException;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = str_replace('Bearer ', "", $request->header('Authorization'));

        try {
            JWTAuth::setToken($token); //<-- set token and check
            if (!$claim = JWTAuth::getPayload()) {
                return response()->json(array('message' => 'user_not_found'), 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(array('message' => 'token_expired'), 401);
        } catch (TokenInvalidException $e) {
            return response()->json(array('message' => 'token_invalid'), 401);
        } catch (JWTException $e) {
            return response()->json(array('message' => 'token_absent'), 401);
        }
        return $next($request);
    }
}
