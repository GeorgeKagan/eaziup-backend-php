<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Exceptions\MyException;

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
        $user = $request->user();

        if ($user->isAuthenticated) {
            return $next($request);
        } else {
            throw new MyException(MyException::TOKEN_NOT_VERIFIED, $user->errorObj);
        }
    }
}
