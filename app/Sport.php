<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $guarded = [];

    /**
     * Set the sport's title.
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = convertArabicStringToPersian($value);
    }

    /**
     * while showing description we use {!! $description !!}}
     * so we clean XSS while saving
     *
     * @param string $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = xssClean(convertArabicStringToPersian($value));
    }
}
