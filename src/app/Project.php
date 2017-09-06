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
     * @param array $data
     * @param string $userId
     */
    public function addProject(array $data, string $userId)
    {
        $this['user_id'] = $userId;

        // Project supplier info
        $this['first_name'] = $data['buyerInfo']['firstName'];
        $this['last_name'] = $data['buyerInfo']['lastName'];
        $this['email'] = $data['buyerInfo']['contactEmail'];
        $this['phone'] = $data['buyerInfo']['contactPhone'];
        $this['country_id'] = $data['buyerInfo']['country'];
        $this['city'] = $data['buyerInfo']['city'];
        $this['addr1'] = $data['buyerInfo']['addressLine1'];
        $this['addr2'] = $data['buyerInfo']['addressLine2'];
        $this['company'] = $data['buyerInfo']['companyName'];
        $this['position'] = $data['buyerInfo']['companyPosition'];
        $this['comp_desc'] = $data['buyerInfo']['whatCompanyDoes'];

        // Project info
        $this['name'] = $data['projectInfo']['projectName'];
        $this['cat_id'] = $data['projectInfo']['cat'];
        $this['desc'] = $data['projectInfo']['basicDesc'];
        $this['full_desc'] = $data['projectInfo']['fullDesc'];
        $this['tech_reqs'] = $data['projectInfo']['techReqs'];
        $this['dev_reqs'] = $data['projectInfo']['developerReqs'];
        // Get OS requirements
        $osReqs = [];
        foreach ($data['projectInfo']['osReqs'] as $os => $isSet) {
            if ($isSet) { $osReqs[] = $os; }
        }
        $this['os_reqs'] = implode(',', $osReqs);

        // Design
        $this['logo_json'] = json_encode($data['design']['logoSlogan']);
        $this['design_json'] = json_encode($data['design']['designIdeas']);
        $this['design_outline'] = $data['design']['designOutline'];

        // Team & milestones
        $startDate = $data['milestones']['startDate'];
        $this['start_date'] = $startDate['year'] . '-' . $startDate['month'] . '-' . $startDate['day'];
        $this['dev_count'] = $data['milestones']['developerCount'];
        $this['milestones_json'] = json_encode($data['milestones']['arr']);

        $this->save();
    }

    /**
     * Return a common project(s) select query object with mandatory filters
     * @param string $userId
     * @return $this
     */
    private static function prepareProjectQuery(string $userId)
    {
        return self::with('cat')
            ->where('user_id', $userId)
            ->where('is_removed', 0);
    }

    /**
     * Get all non-removed projects for user
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll(string $userId)
    {
        return self::prepareProjectQuery($userId)->get();
    }

    /**
     * Get a single project of a user
     * @param int $projectId
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getOne(int $projectId, string $userId)
    {
        return self::prepareProjectQuery($userId)->where('id', $projectId)->first();
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
