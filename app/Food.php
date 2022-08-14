<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $guarded = [];

    /**
     * Set the food's title.
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = xssClean(convertArabicStringToPersian($value));
    }

    /**
     * Set the food's unit.
     *
     * @param string $value
     * @return void
     */
    public function setUnitAttribute($value)
    {
        $this->attributes['unit'] = xssClean(convertArabicStringToPersian($value));
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
