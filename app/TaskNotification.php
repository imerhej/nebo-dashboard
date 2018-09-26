<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskNotification extends Model
{
    protected $table = 'notifications';

    // public function tasks()
    // {
    //     return $this->belongsToMany('App\Tasklist');
    // }
}
