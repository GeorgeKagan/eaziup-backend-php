<?php

namespace App\Exceptions;

use Exception;

class MyException extends Exception
{
    const DEFAULT_ERR_MSG = 'Something went wrong, please try again later';
    const PROJECT_NOT_SAVED = 10;

    public function __construct(int $errorCode, Exception $e)
    {
        if (env('APP_ENV') === 'local') {
            parent::__construct($e->getMessage(), $e->getCode(), $e);
            return;
        }
        parent::__construct(self::DEFAULT_ERR_MSG, $errorCode, $e);
    }
}
