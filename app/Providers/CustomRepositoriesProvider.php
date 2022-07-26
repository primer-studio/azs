<?php

namespace App\Providers;

use App\Libraries\ProfileHelper;
use App\Libraries\InvoiceHelper;
use App\Libraries\SmsHelper;
use App\Libraries\StepHelper;
use App\Libraries\UserHelper;
use Illuminate\Support\ServiceProvider;

class CustomRepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('UserHelper', function () {
            return new UserHelper();
        });

        $this->app->bind('stephelper', function () {
            return new StepHelper();
        });

        // ProfileHelper
        $this->app->bind('profilehelper', function () {
            return new ProfileHelper();
        });

        // InvoiceHelper
        $this->app->bind('invoicehelper', function () {
            return new InvoiceHelper();
        });

        // SmsHelper
        $this->app->bind('smshelper', function () {
            return new SmsHelper();
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
