<?php

namespace App\Http\Controllers;

use App\Application;

class ApplicationController extends Controller
{
    /**
     * Student applies to a project
     * @param int $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentApply(int $projectId) {
        $request = app('request');
        $user = $request->user();
        Application::studentApply($projectId, $user->uuid);

        return parent::success();
    }

    /**
     * Student cancels application to a project
     * @param int $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentApplyCancel(int $projectId) {
        $request = app('request');
        $user = $request->user();
        Application::studentApplyCancel($projectId, $user->uuid);

        return parent::success();
    }
}
