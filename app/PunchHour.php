<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PunchHour extends Model
{
    protected $fillable = [
        'project_id', 'tasklist_id',
    ];
}
