<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function cat()
    {
        return $this->belongsTo('App\Cat');
    }
}
