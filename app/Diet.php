<?php

namespace App;

use Facades\App\Libraries\CacheHelper;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Diet extends Model
{
    use Sluggable;
    protected $guarded = [];

    /**
     * get related steps
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function steps()
    {
        return $this->hasMany('App\Step')->orderBy('sort', "DESC");
    }

    /**
     * get active_periods_steps_questions
     * @return mixed
     */
    public function getActivePeriodsStepsQuestionsAttribute()
    {
        return Cache::remember(CacheHelper::getDietActivePeriodsStepsQuestionsCacheKey($this->id), CacheHelper::getDietCacheSeconds(), function () {
            $periods = $this->periods;
            $periods_steps_questions = $this->steps()
                ->where(['status' => 'active'])
                ->whereIn('period', $periods->where('status', 'active')->pluck('period'))
                ->with(['questions' => function ($q) {
                    $q->where(['status' => 'active']);
                }])
                ->get()->groupBy('period');
            return $this->_periodCreateQuestionsTree($periods_steps_questions);
        });
    }

    /**
     * get periods_steps_questions (all)
     * @return mixed
     */
    public function getPeriodsStepsQuestionsAttribute()
    {
        return Cache::remember(CacheHelper::getDietPeriodsStepsQuestionsCacheKey($this->id), CacheHelper::getDietCacheSeconds(), function () {
            $periods = $this->periods;
            $periods_steps_questions = $this->steps()
                ->whereIn('period', $periods->keys())
                ->with('questions')
                ->get()->groupBy('period');
            return $this->_periodCreateQuestionsTree($periods_steps_questions);
        });
    }

    /**
     * get period_questions
     * @return mixed
     */
    public function getPeriodQuestionsAttribute()
    {
        return Cache::remember(CacheHelper::getDietPeriodQuestionsCacheKeyPrefix($this->id), CacheHelper::getDietCacheSeconds(), function () {
            $questions = [];
            foreach ($this->periods_steps_questions as $period_number => $period) {
                $period_questions = [];
                foreach ($period as $step) {
                    foreach ($step->questions as $question) {
                        $period_questions[$question->id] = $question;
                    }
                }
                $questions[$period_number] = $period_questions;
            }
            return collect($questions);
        });
    }

    /**
     * get period_active_questions
     * @return mixed
     */
    public function getPeriodActiveQuestionsAttribute()
    {
        return Cache::remember(CacheHelper::getDietPeriodActiveQuestionsCacheKey($this->id), CacheHelper::getDietCacheSeconds(), function () {
            return collect($this->period_questions->map(function ($question) {
                return collect($question)->where("status", "active");
            }));
        });
    }

    /**
     * get period_required_questions
     * @return mixed
     */
    public function getPeriodRequiredQuestionsAttribute()
    {
        return Cache::remember(CacheHelper::getDietPeriodRequiredQuestionsCacheKey($this->id), CacheHelper::getDietCacheSeconds(), function () {
            return collect($this->period_questions->map(function ($question) {
                return collect($question)->where("is_required_to_receive_diet", 1);
            }));
        });
    }

    /**
     * get period_active_required_questions
     * @return mixed
     */
    public function getPeriodActiveRequiredQuestionsAttribute()
    {
        return Cache::remember(CacheHelper::getDietPeriodActiveRequiredQuestionsCacheKey($this->id), CacheHelper::getDietCacheSeconds(), function () {
            return collect($this->period_questions->map(function ($question) {
                return collect($question)
                    ->where("status", "active")
                    ->where("is_required_to_receive_diet", 1);
            }));
        });
    }

    protected function _periodCreateQuestionsTree($periods)
    {
        foreach ($periods as $period) {
            foreach ($period as $step) {
                $step->questions_tree = $this->_stepCreateQuestionsTree($step->questions);
            }
        }
        return $periods;
    }

    protected function _stepCreateQuestionsTree($questions_list, $parent_question_id = null)
    {
        $branch = [];
        foreach ($questions_list as $item) {
            if ($item->parent_question_id == $parent_question_id) {
                $children = $this->_stepCreateQuestionsTree($questions_list, $item->id);
                $item['children'] = $children;
                $branch[$item->id] = $item;
            }
        }
        return $branch;
    }

    /**
     * auto decode Periods for each get data from database
     * @param $value
     * @return mixed
     */
    public function getPeriodsAttribute($value)
    {
        return collect(json_decode($value));
    }

    /**
     * Set the diet's title.
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

    public function cartItems()
    {
        return $this->hasMany('App\CartItem');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
