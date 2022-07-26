<?php


namespace App\Libraries;


use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    const DietCacheSeconds = 3600; // 1 hour
    const DietCacheKeyPrefix = "diet.";
    const OrderCacheKeyPrefix = "order.";
    const OrderDietCacheKeyPrefix = "diet.";
    const DietActivePeriodsStepsQuestionsCacheKeyPrefix = "activePeriodsStepsQuestions.";
    const DietPeriodsStepsQuestionsCacheKeyPrefix = "periodsStepsQuestions.";
    const DietPeriodQuestionsCacheKeyPrefix = "periodQuestionsCacheKey.";
    const DietPeriodActiveQuestionsCacheKeyPrefix = "periodActiveQuestionsCacheKey.";
    const DietPeriodRequiredQuestionsCacheKeyPrefix = "requiredQuestionsCacheKey.";
    const DietPeriodActiveRequiredQuestionsCacheKeyPrefix = "activeRequiredQuestionsCacheKey.";

    public function getDietCacheSeconds()
    {
        return self::DietCacheSeconds;
    }

    public function getDietActivePeriodsStepsQuestionsCacheKey($diet_id)
    {
        return self::DietCacheKeyPrefix . self::DietActivePeriodsStepsQuestionsCacheKeyPrefix . $diet_id;
    }

    public function getDietPeriodsStepsQuestionsCacheKey($diet_id)
    {
        return self::DietCacheKeyPrefix . self::DietPeriodsStepsQuestionsCacheKeyPrefix . $diet_id;
    }

    public function getDietPeriodQuestionsCacheKeyPrefix($diet_id)
    {
        return self::DietCacheKeyPrefix . self::DietPeriodQuestionsCacheKeyPrefix . $diet_id;
    }

    public function getDietPeriodActiveQuestionsCacheKey($diet_id)
    {
        return self::DietCacheKeyPrefix . self::DietPeriodActiveQuestionsCacheKeyPrefix . $diet_id;
    }

    public function getDietPeriodRequiredQuestionsCacheKey($diet_id)
    {
        return self::DietCacheKeyPrefix . self::DietPeriodRequiredQuestionsCacheKeyPrefix . $diet_id;
    }

    public function getDietPeriodActiveRequiredQuestionsCacheKey($diet_id)
    {
        return self::DietCacheKeyPrefix . self::DietPeriodActiveRequiredQuestionsCacheKeyPrefix . $diet_id;
    }

    public function getOrderDietCacheKey($order_id)
    {
        return self::OrderDietCacheKeyPrefix . self::OrderDietCacheKeyPrefix . $order_id;
    }

    public function removeOrderCache($order_id)
    {
        Cache::forget($this->getOrderDietCacheKey($order_id));
    }

    public function removeDietCache($diet_id)
    {
        // periods and active periods
        Cache::forget($this->getDietPeriodsStepsQuestionsCacheKey($diet_id));
        Cache::forget($this->getDietActivePeriodsStepsQuestionsCacheKey($diet_id));

        // all period questions and period active questions
        Cache::forget($this->getDietPeriodQuestionsCacheKeyPrefix($diet_id));
        Cache::forget($this->getDietPeriodActiveQuestionsCacheKey($diet_id));

        // all period required questions and period active required questions
        Cache::forget($this->getDietPeriodRequiredQuestionsCacheKey($diet_id));
        Cache::forget($this->getDietPeriodActiveRequiredQuestionsCacheKey($diet_id));
    }

}
