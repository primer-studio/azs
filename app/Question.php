<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Sluggable;
    protected $fillable = [
        'step_id',
        'parent_question_id',
        'available_if_parent_answer_operator',
        'available_if_parent_answer_value',
        'title',
        'short_name',
        'slug',
        'description',
        'status',
        'image',
        'sort',
        'answer_properties',
        'is_required_to_receive_diet',
    ];

    /**
     * get the related step
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function steps()
    {
        return $this->belongsToMany('App\Step');
    }

    /**
     * auto decode answer_properties for each get data from database
     * @param $value
     * @return mixed
     */
    public function getAnswerPropertiesAttribute($value)
    {
        return json_decode($value);;
    }

    /**
     * Set the question's title.
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = xssClean(convertArabicStringToPersian($value));
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
