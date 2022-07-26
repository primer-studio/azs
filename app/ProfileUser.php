<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Profile
{
    /**
     * this is profile table joined with users table
     * this class is extended from Profile model
     * @var string
     */
    protected $table = 'profile_user';
}
