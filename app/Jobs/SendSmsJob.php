<?php

namespace App\Jobs;

use App\Libraries\Sms\SmsProviderAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $_smsProviderObject;

    /**
     * Create a new job instance.
     *
     * @param $smsProviderObject
     */
    private function __construct(SmsProviderAbstract $smsProviderObject)
    {
        $this->_smsProviderObject = $smsProviderObject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->_smsProviderObject->send();
    }
}
