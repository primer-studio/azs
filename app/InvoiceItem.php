<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $guarded = [];


    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function order()
    {
        return $this->hasOne('App\Order');
    }

    public function diet()
    {
        return $this->belongsTo('App\Diet');
    }


    /**
     * auto decode diet_registered_data for each get data from database
     * @param $value
     * @return mixed
     */
    public function getDietRegisteredDataAttribute($value)
    {
        return json_decode($value);;
    }

    /**
     * auto decode pending_questions for each get data from database
     * @param $value
     * @return mixed
     */
    public function getPendingQuestionsAttribute($value)
    {
        return json_decode($value);;
    }

}
