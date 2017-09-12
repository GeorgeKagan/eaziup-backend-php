<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function cat()
    {
        return $this->belongsTo('App\Cat');
    }

    /**
     * Add new project
     * @param Project $projectModel
     * @param array $data
     * @param string $userId
     * @param bool $isEditMode
     */
    public static function saveProject(Project $projectModel, array $data, string $userId, bool $isEditMode)
    {
        if (!$isEditMode) {
            $projectModel['user_id'] = $userId;
        }

        // Project supplier info
        $projectModel['first_name'] = $data['buyerInfo']['firstName'];
        $projectModel['last_name'] = $data['buyerInfo']['lastName'];
        $projectModel['email'] = $data['buyerInfo']['contactEmail'];
        $projectModel['phone'] = $data['buyerInfo']['contactPhone'];
        $projectModel['country_id'] = $data['buyerInfo']['country'];
        $projectModel['city'] = $data['buyerInfo']['city'];
        $projectModel['addr1'] = $data['buyerInfo']['addressLine1'];
        $projectModel['addr2'] = $data['buyerInfo']['addressLine2'];
        $projectModel['company'] = $data['buyerInfo']['companyName'];
        $projectModel['position'] = $data['buyerInfo']['companyPosition'];
        $projectModel['comp_desc'] = $data['buyerInfo']['whatCompanyDoes'];

        // Project info
        $projectModel['name'] = $data['projectInfo']['projectName'];
        $projectModel['cat_id'] = $data['projectInfo']['cat'];
        $projectModel['desc'] = $data['projectInfo']['basicDesc'];
        $projectModel['full_desc'] = $data['projectInfo']['fullDesc'];
        $projectModel['tech_reqs'] = $data['projectInfo']['techReqs'];
        $projectModel['dev_reqs'] = $data['projectInfo']['developerReqs'];
        // Get OS requirements
        $osReqs = [];
        foreach ($data['projectInfo']['osReqs'] as $os => $isSet) {
            if ($isSet) { $osReqs[] = $os; }
        }
        $projectModel['os_reqs'] = implode(',', $osReqs);

        // Design
        $projectModel['logo_json'] = json_encode($data['design']['logoSlogan']);
        $projectModel['design_json'] = json_encode($data['design']['designIdeas']);
        $projectModel['design_outline'] = $data['design']['designOutline'];

        // Team & milestones
        $startDate = $data['milestones']['startDate'];
        $projectModel['start_date'] = $startDate['year'] . '-' . $startDate['month'] . '-' . $startDate['day'];
        $projectModel['dev_count'] = $data['milestones']['developerCount'];
        $projectModel['milestones_json'] = json_encode($data['milestones']['arr']);

        $projectModel->save();
    }

    /**
     * Return a common project(s) select query object with mandatory filters
     * @return $this
     */
    private static function prepareProjectQuery()
    {
        return self::with('cat')
            ->where('is_removed', 0);
    }

    /**
     * Get all active projects for students to pick
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll()
    {
        return self::prepareProjectQuery()->get();
    }

    /**
     * Get all non-removed projects for user
     * @param string $userId
     * @return mixed
     */
    public static function getForUser(string $userId)
    {
        return self::prepareProjectQuery()->where('user_id', $userId)->get();
    }

    /**
     * Get a single project of a user
     * @param int $projectId
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getOne(int $projectId, string $userId)
    {
        return self::prepareProjectQuery()->where('user_id', $userId)->where('id', $projectId)->first();
    }

    /**
     * "Remove" the project (not really -- archive it)
     * @param int $projectId
     * @param string $userId
     */
    public static function markAsRemoved(int $projectId, string $userId)
    {
        $project = self::where(['id' => $projectId, 'user_id' => $userId])->first();
        $project->is_removed = 1;
        $project->save();
    }
}
