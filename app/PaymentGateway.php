<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $guarded = [];


    /**
     * auto decode data for each get data from database
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value);;
    }

    public function invoices()
    {
        return $this->hasMany("App\Invoice", 'ipg_gateway_id');
    }
}
