<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'start_date', 'start_time', 'end_date', 'end_time', 'reason', 'status',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
