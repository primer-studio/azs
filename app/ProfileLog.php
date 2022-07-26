<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileLog extends Model
{
    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function performer()
    {
        return $this->morphTo(null, 'performer_model_type', 'performer_model_id');
    }

}
