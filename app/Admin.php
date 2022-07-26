<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profileLogs()
    {
        return $this->morphMany('App\ProfileLog', 'profileLogAble', 'performer_model_type','performer_model_id');
    }

    /**
     * Set the admin's name.
     *
     * @param string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = convertArabicStringToPersian($value);
    }
}
