<?php

namespace App\Http\Controllers;

use App\Exceptions\MyException;
use App\Project;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function save()
    {
        $request = app('request');
        $data = $request->all();
        $project = new Project;

        try {
            $project['name'] = $data['projectInfo']['projectName'];
            $project->save();
        }
        catch (Exception $e) {
            throw new MyException(MyException::PROJECT_NOT_SAVED, $e);
        }

        return parent::success();
    }
}
