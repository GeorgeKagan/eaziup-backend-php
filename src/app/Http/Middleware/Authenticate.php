<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Auth0\SDK\JWTVerifier;
use App\Config\Config;
use App\Exceptions\MyException;
use Exception;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws MyException
     */
    public function handle($request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');
        $jwt = trim(str_replace('Bearer ', '', $authorizationHeader));
        $verifier = new JWTVerifier([
            'supported_algs' => [Config::AUTH0['ALGORITHM']],
            'valid_audiences' => [Config::AUTH0['CLIENT_ID']],
            'authorized_iss' => [Config::AUTH0['DOMAIN']]
        ]);
        try {
            $verifier->verifyAndDecode($jwt);
            return $next($request);
        } catch (Exception $e) {
            throw new MyException(MyException::TOKEN_NOT_VERIFIED, $e);
        }
    }
}
