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
        return Project::getAll($request->user()->uuid);
    }

    public function getOne(int $projectId)
    {
        $request = app('request');
        return Project::getOne($projectId, $request->user()->uuid);
    }

    public function save()
    {
        $request = app('request');
        $data = $request->all();
        $user = $request->user();

        try {
            // Edit mode
            if ($data['id']) {
                $project = Project::find($data['id']);
                Project::saveProject($project, $data, $user->uuid, true);
            } else {
                $project = new Project();
                Project::saveProject($project, $data, $user->uuid, false);
            }
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
