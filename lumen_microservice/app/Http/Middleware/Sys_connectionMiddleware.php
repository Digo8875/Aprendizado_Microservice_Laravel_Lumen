<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Sys_connection;

class Sys_connectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sys_connection = Sys_connection::where('sys_access_token', '=', $request->bearerToken())->first();
        
        if(is_null($sys_connection))
            return response('Unauthorized.', 401);

        if(!$request->headers->has('jwt-token'))
            return response('Unauthorized.', 401);

        $token = $request->header('jwt-token');

        $token = explode('.', $token);

        $access_token = json_decode(base64_decode($token[1]))->access_token;

        if($access_token != $request->bearerToken())
            return response('Unauthorized.', 401);
        
        $header = $token[0];
        $payload = $token[1];
        $sign = $token[2];

        $verify_key = $sys_connection->sys_key.':'.$sys_connection->sys_secret;
        $key = base64_encode($verify_key);

        $sign_server = hash_hmac('sha256', $header . "." . $payload, $key, true);
        $sign_server = base64_encode($sign_server);

        if($sign != $sign_server)
            return response('Unauthorized.', 401);

        return $next($request);
    }
}