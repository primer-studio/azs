<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\VerifiedInvoiceEvent' => [
            'App\Listeners\VerifiedInvoiceListener',
        ],
        'App\Events\PendingInvoiceItemEvent' => [
            'App\Listeners\PendingInvoiceItemListener',
        ],
        'App\Events\InvoiceStoredEvent' => [
            'App\Listeners\InvoiceStoredListener',
        ],
        'App\Events\DietStoredEvent' => [
            'App\Listeners\DietStoredListener',
        ],
        'App\Events\StepStoredEvent' => [
            'App\Listeners\StepStoredListener',
        ],
        'App\Events\QuestionStoredEvent' => [
            'App\Listeners\QuestionStoredListener',
        ],
        'App\Events\FoodStoredEvent' => [
            'App\Listeners\FoodStoredListener',
        ],
        'App\Events\SportStoredEvent' => [
            'App\Listeners\SportStoredListener',
        ],
        'App\Events\RecommendationStoredEvent' => [
            'App\Listeners\RecommendationStoredListener',
        ],
        'App\Events\OrderStoredEvent' => [
            'App\Listeners\OrderStoredListener',
        ],
        'App\Events\OrderCompletedEvent' => [
            'App\Listeners\OrderCompletedListener',
        ],
        'App\Events\OrderSeenEvent' => [
            'App\Listeners\OrderSeenListener',
        ],
        'App\Events\OrderCreatedEvent' => [
            'App\Listeners\OrderCreatedListener',
        ],
        'App\Events\DailyPlanStoredEvent' => [
            'App\Listeners\DailyPlanStoredListener',
        ],
        'App\Events\OfflinePaymentRegisteredEvent' => [
            'App\Listeners\OfflinePaymentRegisteredListener',
        ],
        'App\Events\OfflinePaymentVerifiedEvent' => [
            'App\Listeners\OfflinePaymentVerifiedListener',
        ],
        'App\Events\UserLoginEvent' => [
            'App\Listeners\UserLoginListener',
        ],
        'App\Events\ProfileStoredEvent' => [
            'App\Listeners\ProfileStoredListener',
        ],
        'App\Events\ProfileUpdatedEvent' => [
            'App\Listeners\ProfileUpdatedListener',
        ],
        'App\Events\ProfileUpdateRequestEvent' => [
            'App\Listeners\ProfileUpdateRequestListener',
        ],
        'App\Events\CartItemStoredEvent' => [
            'App\Listeners\CartItemStoredListener',
        ],
        'App\Events\CartItemUpdatedEvent' => [
            'App\Listeners\CartItemUpdatedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
