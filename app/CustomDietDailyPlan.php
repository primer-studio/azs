<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomDietDailyPlan extends Model
{
    protected $fillable = [
        'order_id',
        'plan'
    ];

    public function Order() {
        return $this->belongsTo('App\Order');
    }
}
