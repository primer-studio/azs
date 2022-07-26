<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use Sluggable;
    protected $fillable = [
        'diet_id',
        'period',
        'title',
        'slug',
        'description',
        'status',
        'image',
        'sort',
    ];

    /**
     * get the related diet
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diet()
    {
        return $this->belongsTo('App\Diet');
    }

    /**
     * get related questions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Question')->withPivot('sort')->orderBy('question_step.sort', 'ASC');;
    }

    /**
     * Set the step's title.
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
