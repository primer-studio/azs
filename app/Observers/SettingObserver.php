<?php

namespace App\Observers;

use App\Setting;
use Facades\App\Libraries\SettingHelper;

class SettingObserver
{
    /**
     * Handle the setting "created" event.
     *
     * @param \App\Setting $setting
     * @return void
     */
    public function created(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "updated" event.
     *
     * @param \App\Setting $setting
     * @return void
     */
    public function updated(Setting $setting)
    {
        // update settings cache
        SettingHelper::getSettings(true);
    }

    /**
     * Handle the setting "deleted" event.
     *
     * @param \App\Setting $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "restored" event.
     *
     * @param \App\Setting $setting
     * @return void
     */
    public function restored(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "force deleted" event.
     *
     * @param \App\Setting $setting
     * @return void
     */
    public function forceDeleted(Setting $setting)
    {
        //
    }
}
