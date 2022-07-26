<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliationPartner extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = convertArabicStringToPersian($value);
    }

    public function setMobileNumberAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['mobile_number'] = toEnglishDigit($value);
        } else {
            $this->attributes['mobile_number'] = null;
        }
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function affiliationInvoices()
    {
        return $this->hasMany('App\AffiliationInvoice');
    }
}
