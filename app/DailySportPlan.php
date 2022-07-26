<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class DailySportPlan extends Model
{
    // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
    use InsertOnDuplicateKey;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }


    public function sport()
    {
        return $this->belongsTo('App\Sport');
    }

    /**
     * Set the before_sport_comment
     *
     * @param string $value
     * @return void
     */
    public function setBeforeSportCommentAttribute($value)
    {
        $this->attributes['before_sport_comment'] = xssClean(convertArabicStringToPersian($value));
    }

    /**
     * Set the after_sport_comment
     *
     * @param string $value
     * @return void
     */
    public function setAfterSportCommentAttribute($value)
    {
        $this->attributes['after_sport_comment'] = xssClean(convertArabicStringToPersian($value));
    }
}
