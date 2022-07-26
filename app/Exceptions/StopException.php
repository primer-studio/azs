<?php

namespace App\Exceptions;

use App\Mail\StopExceptionMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class StopException extends Exception
{
    public $messageToDisplay;

    public function __construct($message = "", $message_to_display = '', $code = 0, Throwable $previous = null)
    {
        $this->messageToDisplay = $message_to_display;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        $log_id = time() . uniqid();
        $request_uri = htmlspecialchars(url()->current(), ENT_QUOTES, 'utf-8');
        Log::emergency('StopException', [
            'type' => 'StopException',
            'log_id' => $log_id,
            'message' => $this->getMessage(),
            'message_to_display' => $this->messageToDisplay,
            'code' => $this->getCode(),
            'request_uri' => $request_uri,
        ]);
        Mail::send(new StopExceptionMail($this->getMessage(), $this->getCode(), $log_id, $request_uri, $this->messageToDisplay));
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
        return view('main')->nest('content', 'exceptions.stop-exception', compact('message'));
    }
}
