<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function tasklist()
    {
        return $this->belongsToMany('App\Tasklist');
    }

    public function milestone()
    {
        return $this->belongsToMany('App\Milestone');
    }

    public function category()
    {
        return $this->belongsToMany('App\Category');
    }

    public function department()
    {
        return $this->belongsToMany('App\Department');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Client');
    }

    public function files()
    {
        return $this->belongsToMany('App\File');
    }

    public function discussions()
    {
        return $this->belongsToMany('App\Discussion');
    }

    public function projectDetail()
    {
        return $this->hasOne(ProjectDetail::class);
    }

}
