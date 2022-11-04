<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;


class ProfileAssets extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'profile_id',
        'asset_type',
        'asset_visibility',
        'asset_info',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }




    /**
     * helper methods
     * */
    public function getType() {
        return $this->asset_type;
    }
    public function getInfo($associative = false) {
        return json_decode($this->asset_info, $associative);
    }
    public function getURL()
    {
        $id = $this->id;
        return route('dashboard.assets.secretURL', Crypt::encryptString($id));
    }
}
