<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprehensiveReport extends Model
{
    protected $table = 'comprehensive_report';


    public function diet()
    {
        return $this->belongsTo('App\Diet');
    }

    public function cartItems()
    {
        return $this->hasMany('App\CartItem', 'profile_id', 'profile_id');
    }

    public function inProgressBy()
    {
        return $this->belongsTo('App\Admin', 'in_progress_by', 'id');
    }
}
