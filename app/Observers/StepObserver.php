<?php

namespace App\Observers;

use Facades\App\Libraries\DietHelper;
use App\Step;

class StepObserver
{

    /**
     * Handle the step "created" event.
     *
     * @param \App\Step $step
     * @return void
     */
    public function created(Step $step)
    {
    }

    /**
     * Handle the step "updated" event.
     *
     * @param \App\Step $step
     * @return void
     */
    public function updated(Step $step)
    {
    }

    /**
     * Handle the step "deleted" event.
     *
     * @param \App\Step $step
     * @return void
     */
    public function deleted(Step $step)
    {
    }

    /**
     * Handle the step "restored" event.
     *
     * @param \App\Step $step
     * @return void
     */
    public function restored(Step $step)
    {
    }

    /**
     * Handle the step "force deleted" event.
     *
     * @param \App\Step $step
     * @return void
     */
    public function forceDeleted(Step $step)
    {
    }
}
