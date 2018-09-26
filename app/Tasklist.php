<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    protected $fillable = [
        'active',
    ];

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function milestones()
    {
        return $this->belongsToMany('App\Milestone');
    }

    // public function notifications()
    // {
    //     return $this->belongsToMany('App\Notification');
    // }

}
