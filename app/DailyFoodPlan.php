<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class DailyFoodPlan extends Model
{
    // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
    use InsertOnDuplicateKey;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function food()
    {
        return $this->belongsTo('App\Food');
    }

    /**
     * Set the before_food_comment
     *
     * @param string $value
     * @return void
     */
    public function setBeforeFoodCommentAttribute($value)
    {
        $this->attributes['before_food_comment'] = xssClean(convertArabicStringToPersian($value));
    }

    /**
     * Set the after_food_comment
     *
     * @param string $value
     * @return void
     */
    public function setAfterFoodCommentAttribute($value)
    {
        $this->attributes['after_food_comment'] = xssClean(convertArabicStringToPersian($value));
    }
}
