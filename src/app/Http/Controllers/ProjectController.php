<?php

namespace App\Http\Controllers;

use App\Application;
use App\Exceptions\MyException;
use App\Project;
use App\User;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        $request = app('request');
        $isAll = $request->input('all', false);

        // For a student
        if ($isAll) {
            return Project::getAll();
        }
        // For an entrepreneur (only his projects)
        else {
            return Project::getForUser($request->user()->uuid);
        }
    }

    public function getOne(int $projectId)
    {
        $project = Project::getOne($projectId);

        if (User::isStudent()) {
            $project['application'] = Application::isStudentApplied($projectId);
        }

        return $project;
    }

    public function save()
    {
        $request = app('request');
        $data = $request->all();
        $user = $request->user();

        try {
            // Edit mode
            if (!empty($data['id'])) {
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
