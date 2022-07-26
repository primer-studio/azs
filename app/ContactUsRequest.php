<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsRequest extends Model
{
    protected $guarded = [];

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = xssClean(convertArabicStringToPersian($value));
    }
}
