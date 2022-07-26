<?php

namespace App\Exceptions;

use App\Constants\ErrorResponse;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            // return Api Exception response if request expects json
            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                return setErrorResponse('NOT_FOUND', ErrorResponse::NOT_FOUND, Response::HTTP_NOT_FOUND);
            }

            // too_many_attempts
            if ($exception instanceof ThrottleRequestsException) {
                return setErrorResponse(__('general.too_many_attempts'));
            }
        }
        return parent::render($request, $exception);
    }


    /**
     * override unauthenticated method to set proper response
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? setErrorResponse('unauthorized', ErrorResponse::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}
