<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class DailyRecommendationPlan extends Model
{
    // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
    use InsertOnDuplicateKey;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function recommendation()
    {
        return $this->belongsTo('App\Recommendation');
    }

    /**
     * Set the before_recommendation_comment
     *
     * @param string $value
     * @return void
     */
    public function setBeforeRecommendationCommentAttribute($value)
    {
        $this->attributes['before_recommendation_comment'] = xssClean(convertArabicStringToPersian($value));
    }

    /**
     * Set the after_recommendation_comment
     *
     * @param string $value
     * @return void
     */
    public function setAfterRecommendationCommentAttribute($value)
    {
        $this->attributes['after_recommendation_comment'] = xssClean(convertArabicStringToPersian($value));
    }
}
