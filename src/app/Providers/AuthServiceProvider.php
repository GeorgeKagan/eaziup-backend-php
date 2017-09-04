<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Helpers\Cache\FileSystemCacheHandler;
use App\Config\Config;
use Exception;

class AuthServiceProvider extends ServiceProvider
{
    const IS_AUTHENTICATED = 'isAuthenticated';
    const EXPIRATION = 'expiration';
    const UUID = 'uuid';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            // Get auth0 idToken via header
            $authorizationHeader = $request->header('Authorization');
            $jwt = trim(str_replace('Bearer ', '', $authorizationHeader));

            if ($jwt === 'null') {
                return (object)[self::IS_AUTHENTICATED => false];
            }
            // Init JWT verifier object
            $verifier = new JWTVerifier([
                'supported_algs' => [Config::AUTH0['ALGORITHM']],
                'valid_audiences' => [Config::AUTH0['CLIENT_ID']],
                'authorized_iss' => [Config::AUTH0['DOMAIN']],
                'cache' => new FileSystemCacheHandler()
            ]);
            // Try to decode and verify the token
            try {
                $data = $verifier->verifyAndDecode($jwt);
                $data->{self::IS_AUTHENTICATED} = true;
                $data->{self::EXPIRATION} = $data->exp;
                $data->{self::UUID} = $data->sub;
                return $data;
            }
            // Bad token (expired, incorrect, ...)
            catch (Exception $e) {
                return (object)[self::IS_AUTHENTICATED => false, 'errorObj' => $e];
            }
        });
    }
}
