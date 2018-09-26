<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
