<?php


namespace App\Libraries;


use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    /**
     * get settings data from cache, otherwise get data from database and save it in cache for next calls
     * @param bool $force_to_refresh_cache
     * @return mixed
     */
    public function getSettings($force_to_refresh_cache = false)
    {
        $cache_key = 'settings';
        // delete cache to get fresh data from DB
        if ($force_to_refresh_cache) {
            Cache::forget($cache_key);
        }
        $settings = Cache::rememberForever($cache_key, function () {
            return Setting::first();
        });

        return $settings;
    }
}
