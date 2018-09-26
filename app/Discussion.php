<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }
}
