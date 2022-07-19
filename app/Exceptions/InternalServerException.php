<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class InternalServerException extends BaseException
{
    /**
     * Constructor
     *
     * @param ?string $message
     * @param ?int $code
     */
    public function __construct(?string $message = null, ?int $code = null)
    {
        parent::__construct(
            $message ?? Response::$statusTexts[
                Response::HTTP_INTERNAL_SERVER_ERROR
            ],
            $code ?? Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
