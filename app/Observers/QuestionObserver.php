<?php

namespace App\Observers;

use Facades\App\Libraries\QuestionHelper;
use App\Question;

class QuestionObserver
{
    /**
     * Handle the question "created" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function created(Question $question)
    {
    }

    /**
     * Handle the question "updated" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function updated(Question $question)
    {
    }

    /**
     * Handle the question "deleted" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function deleted(Question $question)
    {
    }

    /**
     * Handle the question "restored" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function restored(Question $question)
    {
    }

    /**
     * Handle the question "force deleted" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function forceDeleted(Question $question)
    {
    }
}
