<?php

namespace App;

class User
{
    /**
     * Check if API request issuing user is a student (and not an entrepreneur)
     * @return bool
     */
    public static function isStudent()
    {
        $request = app('request');

        return $request->header('IsStudent') === 'true';
    }
}
