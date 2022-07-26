<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliationInvoice extends Model
{
    protected $guarded = [];

    public function affiliationPartner()
    {
        return $this->belongsTo('App\AffiliationPartner');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

}
