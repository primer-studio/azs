<?php

namespace App\Exceptions;

use App\Mail\StopExceptionMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class IPGStopException extends Exception
{
    public $messageToDisplay;
    public $invoice;
    public $responseBodyAsString;
    public $gateway;
    public $report;

    public function __construct($gateway, $invoice, $message_to_log = "", $message_to_display = '', $exception = null, $report = false)
    {
        $this->gateway = $gateway;
        $this->invoice = $invoice;
        $this->messageToDisplay = $message_to_display;
        $this->report = $report;

        $this->responseBodyAsString = '';
        if (!is_null($exception)) {
            $response = $exception->getResponse();
            $this->responseBodyAsString = $response->getBody()->getContents();
        }

        parent::__construct($message_to_log);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        if (!$this->report) {
            return;
        }
        $log_id = time() . uniqid();
        $request_uri = htmlspecialchars(url()->current(), ENT_QUOTES, 'utf-8');

        $invoice = json_encode($this->invoice);
        Log::emergency('StopException', [
            'type' => 'StopException',
            'log_id' => $log_id,
            'message' => $this->getMessage(),
            'message_to_display' => $this->messageToDisplay,
            'invoice' => $invoice,
            'response_body_as_string' => $this->responseBodyAsString,
            'code' => $this->getCode(),
            'request_uri' => $request_uri,
        ]);
        $message = $this->getMessage();
        $message .= "$message,\n invoice: $invoice,\n response_body_as_string: $this->responseBodyAsString";
        $message_to_display = $this->messageToDisplay . $this->responseBodyAsString;
        Mail::send(new StopExceptionMail($message, $this->getCode(), $log_id, $request_uri, $message_to_display));
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $message = $this->messageToDisplay;
        $errors = [];
        if (!empty($this->responseBodyAsString)) {
            $errors = json_decode($this->responseBodyAsString);
        }
        return view('main')->nest('content', 'exceptions.ipg-stop-exception', compact('message', 'errors'));
    }
}
