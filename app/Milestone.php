<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function tasklists()
    {
        return $this->belongsToMany('App\Tasklist');
    }
}
