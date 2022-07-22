<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UnauthorizedException extends BaseException
{
    /**
     * Constructor
     *
     * @param ?string $message
     * @param ?int $code
     *
     * @return void
     */
    public function __construct(?string $message = null, ?int $code = null)
    {
        parent::__construct(
            $message ?? Response::$statusTexts[Response::HTTP_UNAUTHORIZED],
            $code ?? Response::HTTP_UNAUTHORIZED
        );
    }
}
