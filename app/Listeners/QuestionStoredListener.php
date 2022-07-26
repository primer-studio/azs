<?php

namespace App\Listeners;

use App\Events\QuestionStoredEvent;
use App\Step;
use Facades\App\Libraries\CacheHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QuestionStoredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param QuestionStoredEvent $event
     * @return void
     */
    public function handle(QuestionStoredEvent $event)
    {
        $question = $event->question;
        $steps = Step::whereHas('questions', function ($query) use ($question) {
            $query->where('questions.id', $question->id);
        })->get();
        foreach ($steps as $step) {
            CacheHelper::removeDietCache($step->diet_id);
        }
    }
}
