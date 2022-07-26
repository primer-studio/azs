<?php

namespace App\Jobs;

use App\Mail\PendingInvoiceItemMail;
use App\Mail\verificationTest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendUserMobileVerificationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mobile;
    public $code;

    /**
     * Create a new message instance.
     *
     * @param $mobile
     * @param $code
     */
    public function __construct($mobile, $code)
    {
        //
        $this->mobile = $mobile;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new verificationTest($this->mobile, $this->code));
    }
}
