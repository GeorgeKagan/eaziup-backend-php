<?php

namespace App\Http\Controllers;

use App\Exceptions\MyException;
use App\Project;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        $request = app('request');
        return Project::with('cat')
            ->where('user_id', $request->user()->uuid)
            ->where('is_removed', 0)
            ->get();
    }

    public function save()
    {
        $request = app('request');
        $data = $request->all();
        $user = $request->user();
        $project = new Project;

        try {
            $project->addProject($data, $user->uuid);
        }
        catch (Exception $e) {
            throw new MyException(MyException::PROJECT_NOT_SAVED, $e);
        }

        return parent::success();
    }

    public function remove(int $projectId)
    {
        $request = app('request');
        $user = $request->user();
        Project::markAsRemoved($projectId, $user->uuid);

        return parent::success();
    }
}
