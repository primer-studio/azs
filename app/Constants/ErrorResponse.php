<?php


namespace App\Constants;


class ErrorResponse
{
    /**
     * these constants are used as error code in api responses
     */
    // TODO[back-end]: put this codes in document
    const VALIDATION = 100; // laravel validator fails
    const WRONG_AUTHENTICATION_INPUT = 200; // wrong data for login
    const NOT_FOUND = 404; // not found
    const UNAUTHORIZED = 401; // unauthorized
}
