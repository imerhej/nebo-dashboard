<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'middleName', 'lastName', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsToMany(Department::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function discussion()
    {
        return $this->hasOne('App\Discussion');
    }

    public function file()
    {
        return $this->hasOne('App\File');
    }

    public function tasklists()
    {
        return $this->belongsToMany('App\Tasklist');
    }

    public function leaves()
    {
        return $this->belongsToMany('App\Leave');
    }

    public function messages()
    {
        return $this->belongsToMany('App\Message');
    }

}
