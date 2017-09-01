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
            // Project supplier info
            $project['first_name'] = $data['buyerInfo']['firstName'];
            $project['last_name'] = $data['buyerInfo']['lastName'];
            $project['email'] = $data['buyerInfo']['contactEmail'];
            $project['phone'] = $data['buyerInfo']['contactPhone'];
            $project['country_id'] = $data['buyerInfo']['country'];
            $project['city'] = $data['buyerInfo']['city'];
            $project['addr1'] = $data['buyerInfo']['addressLine1'];
            $project['addr2'] = $data['buyerInfo']['addressLine2'];
            $project['company'] = $data['buyerInfo']['companyName'];
            $project['position'] = $data['buyerInfo']['companyPosition'];
            $project['comp_desc'] = $data['buyerInfo']['whatCompanyDoes'];

            // Project info
            $project['name'] = $data['projectInfo']['projectName'];
            $project['cat_id'] = $data['projectInfo']['cat'];
            $project['desc'] = $data['projectInfo']['basicDesc'];
            $project['full_desc'] = $data['projectInfo']['fullDesc'];
            $project['tech_reqs'] = $data['projectInfo']['techReqs'];
            $project['dev_reqs'] = $data['projectInfo']['developerReqs'];
            // Get OS requirements
            $osReqs = [];
            foreach ($data['projectInfo']['osReqs'] as $os => $isSet) {
                if ($isSet) { $osReqs[] = $os; }
            }
            $project['os_reqs'] = implode(',', $osReqs);

            // Design
            $project['logo_json'] = json_encode($data['design']['logoSlogan']);
            $project['design_json'] = json_encode($data['design']['designIdeas']);
            $project['design_outline'] = $data['design']['designOutline'];

            // Team & milestones
            $startDate = $data['milestones']['startDate'];
            $project['start_date'] = $startDate['year'] . '-' . $startDate['month'] . '-' . $startDate['day'];
            $project['dev_count'] = $data['milestones']['developerCount'];
            $project['milestones_json'] = json_encode($data['milestones']['arr']);

            $project->save();
        }
        catch (Exception $e) {
            throw new MyException(MyException::PROJECT_NOT_SAVED, $e);
        }

        return parent::success();
    }
}
