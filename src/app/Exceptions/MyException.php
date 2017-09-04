<?php

namespace App\Exceptions;

use Exception;

class MyException extends Exception
{
    const PROJECT_NOT_SAVED = 10;
    const TOKEN_NOT_VERIFIED = 20;

    private $messages = [
        self::PROJECT_NOT_SAVED => 'Something went wrong, please try again later',
        self::TOKEN_NOT_VERIFIED => 'Could not authenticate, please login again'
    ];

    public function __construct(int $errorCode, Exception $e = null)
    {
        if (env('APP_ENV') === 'local' && $e) {
            parent::__construct($e->getMessage(), $e->getCode(), $e);
            return;
        }
        parent::__construct($this->messages[$errorCode], $errorCode, $e);
    }
}
