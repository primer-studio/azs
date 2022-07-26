<?php

namespace App\Observers;

use App\Diet;
use Facades\App\Libraries\DietHelper;

class DietObserver
{
    /**
     * Handle the diet "created" event.
     *
     * @param  \App\Diet  $diet
     * @return void
     */
    public function created(Diet $diet)
    {

    }

    /**
     * Handle the diet "updated" event.
     *
     * @param  \App\Diet  $diet
     * @return void
     */
    public function updated(Diet $diet)
    {
    }

    /**
     * Handle the diet "deleted" event.
     *
     * @param  \App\Diet  $diet
     * @return void
     */
    public function deleted(Diet $diet)
    {
    }

    /**
     * Handle the diet "restored" event.
     *
     * @param  \App\Diet  $diet
     * @return void
     */
    public function restored(Diet $diet)
    {
    }

    /**
     * Handle the diet "force deleted" event.
     *
     * @param  \App\Diet  $diet
     * @return void
     */
    public function forceDeleted(Diet $diet)
    {
    }
}
