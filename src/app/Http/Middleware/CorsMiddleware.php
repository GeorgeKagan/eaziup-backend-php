<?php namespace App\Http\Middleware;

use Illuminate\Http\Response;

class CorsMiddleware
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');

        // If pre-flight return 204 success code
        if ($request->getMethod() === 'OPTIONS' && $response->getStatusCode() === 405) {
            return new Response('', 204, $response->headers->all());
        }
        return $response;
    }
}