<?php

namespace App;

use Carbon\Carbon;
use Facades\App\Libraries\CacheHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    protected $guarded = [];

    public function invoiceItem()
    {
        return $this->belongsTo('App\InvoiceItem');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function dailyFoodPlans()
    {
        return $this->hasMany('App\DailyFoodPlan');
    }

    public function dailySportPlans()
    {
        return $this->hasMany('App\DailySportPlan');
    }

    public function dailyRecommendationPlans()
    {
        return $this->hasMany('App\DailyRecommendationPlan');
    }

    public function getDietAttribute()
    {
        return Cache::rememberForever(CacheHelper::getOrderDietCacheKey($this->id), function () {
            $order = Order::with([
                'dailyFoodPlans' => function ($q) {
                    $q->orderBy('section', 'ASC')->with('food');
                },
                'dailySportPlans' => function ($q) {
                    $q->orderBy('section', 'ASC')->with('sport');
                },
                'dailyRecommendationPlans' => function ($q) {
                    $q->orderBy('section', 'ASC')->with('recommendation');
                }
            ])->find($this->id);

            $days_grouped = new \stdClass();
            $days_grouped->days = collect([]);
            $days_grouped->foods = collect([]);
            $days_grouped->sports = collect([]);
            $days_grouped->recommendations = collect([]);

            if (!empty($order->start_date)) {
                for ($day = 1; $day <= $order->duration_in_day; $day++) {
                    $days_grouped->days[$day] = Carbon::createFromTimestamp($order->start_date)->addDay($day - 1)->timestamp;
                }
            }

            // foods
            $food_days = $order->dailyFoodPlans->groupBy('day');
            foreach ($food_days as $day => $meals) {
                $days_grouped->foods[$day] = $meals->groupBy('meal');
            }

            // sports
            $sport_days = $order->dailySportPlans->groupBy('day');
            foreach ($sport_days as $day => $sport) {
                $days_grouped->sports[$day] = $sport;
            }

            // recommendations
            $recommendation_days = $order->dailyRecommendationPlans->groupBy('day');
            foreach ($recommendation_days as $day => $recommendation) {
                $days_grouped->recommendations[$day] = $recommendation;
            }

            return $days_grouped;
        });
    }

    public function setStartDateAttribute($value)
    {
        $start_date = Carbon::createFromTimestamp(jdateToTimestamp($value))->startOfDay();
        $this->attributes['start_date'] = $start_date->timestamp;
        $this->attributes['end_date'] = $start_date->addDay($this->duration_in_day - 1)->timestamp;
    }



}
