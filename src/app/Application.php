<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $timestamps = false;

    /**
     * Insert a row representing a student's application to a certain project
     * @param int $projectId
     * @param string $userId
     */
    public static function studentApply(int $projectId, string $userId)
    {
        $application = new Application;
        $application['user_id'] = $userId;
        $application['project_id'] = $projectId;
        $application->save();
    }

    /**
     * Check if student applied to specified project
     * @param int $projectId
     * @return array
     */
    public static function isStudentApplied(int $projectId)
    {
        $isApplied = self::where('project_id', '=', $projectId)->select('id AS isApplied')->first();
        return ['isApplied' => (bool)$isApplied];
    }
}
