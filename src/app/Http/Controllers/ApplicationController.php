<?php

namespace App\Http\Controllers;

use App\Application;

class ApplicationController extends Controller
{
    public function studentApply(int $projectId) {
        $request = app('request');
        $user = $request->user();
        Application::studentApply($projectId, $user->uuid);

        return parent::success();
    }
}
