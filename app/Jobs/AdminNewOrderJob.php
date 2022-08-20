<?php

namespace App\Jobs;

use App\Mail\OrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AdminNewOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $backpack;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($backpack)
    {
        $this->backpack = $backpack;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (explode('***', env('SYSTEM_ADMINS_LIST')) as $recipient) {
            Mail::to($recipient)->send(new OrderCreated($this->backpack));
        }
    }
}
