<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class BaseException extends Exception
{
    /**
     * Constructor
     *
     * @param ?string $message
     * @param ?int $code
     */
    public function __construct(?string $message = null, ?int $code = null)
    {
        parent::__construct($message, $code);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render()
    {
        return response([
            'errors' => [
                'status' => $this->code,
                'title' => Response::$statusTexts[$this->code],
                'detail' => $this->message

            ]
        ], $this->code);
    }
}
