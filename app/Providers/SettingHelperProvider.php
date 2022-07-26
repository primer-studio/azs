<?php

namespace App\Providers;

use App\Libraries\SettingHelper;
use Illuminate\Support\ServiceProvider;

class SettingHelperProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SettingHelper', function () {
            return new SettingHelper();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
