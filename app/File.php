<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
