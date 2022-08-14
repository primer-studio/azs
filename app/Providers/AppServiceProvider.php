<?php

namespace App\Providers;

use App\Diet;
use App\Observers\DietObserver;
use App\Observers\QuestionObserver;
use App\Observers\SettingObserver;
use App\Observers\StepObserver;
use App\Question;
use App\Setting;
use App\Step;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        // settings model observer to update settings cache after database changes
        Setting::observe(SettingObserver::class);
        // diet model observer to update diet cache after database changes
        Diet::observe(DietObserver::class);
        // step model observer to update step cache after database changes
        Step::observe(StepObserver::class);
        // question model observer to update question cache after database changes
        Question::observe(QuestionObserver::class);
        // this component just can be used in admin area (panel)



        # =========================  push once - start ========================= #
        // add new directive 'pushonce' to blade, by using this directive if the pushed script, has been pushed before, it does not push again
        Blade::directive('pushonce', function ($expression) {
            // remove "'" from $expression
            $domain = explode(':', trim(substr($expression, 1, -1)));
            $push_name = $domain[0];
            // replace not allowed characters
            $push_sub = preg_replace("([^a-zA-Z0-9]+)", "_", $domain[1]);
            // $push_name for each script must be unique
            $isDisplayed = '__pushonce_' . $push_name . '_' . $push_sub;
            return "<?php if(!isset(\$__env->{$isDisplayed})): \$__env->{$isDisplayed} = true; \$__env->startPush('{$push_name}'); ?>";
        });
        Blade::directive('endpushonce', function ($expression) {
            return '<?php $__env->stopPush(); endif; ?>';
        });
        # =========================  push once -  end  ========================= #

        # =========================  blade components - start ========================= #
        Blade::aliasComponent('panel.components.lfmUploadButton', 'LfmUploadButton');
        // ajax form for admin (panel)
        Blade::aliasComponent('panel.components.AjaxForm', 'AjaxForm');
        // ajax form for user (dashboard)
        Blade::aliasComponent('dashboard.components.UserAjaxForm', 'UserAjaxForm');
        // persian-datepicker-input (general)
        Blade::aliasComponent('panel.components.PersianDatepicker', 'PersianDatepicker');
        // persian-datepicker-input (general)
        Blade::aliasComponent('dashboard.components.UserPersianDatepicker', 'UserPersianDatepicker');
        // separated persian-datepicker-input (general)
        Blade::aliasComponent('dashboard.components.UserSeparatedPersianDatepicker', 'UserSeparatedPersianDatepicker');
        // bmi calculator (dashboard)
        Blade::aliasComponent('dashboard.components.UserBmiCalculator', 'UserBmiCalculator');
        # =========================  blade components -  end  ========================= #
    }
}
