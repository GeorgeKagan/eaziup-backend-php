<?php

namespace App\Http\Controllers;

use App\Project;

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

        $project->name = $data['projectInfo']['projectName'];

        $project->save();

        return $data;
    }
}
