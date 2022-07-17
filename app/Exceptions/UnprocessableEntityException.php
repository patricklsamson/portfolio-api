<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class UnprocessableEntityException extends BaseException
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
            $message ?? Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
            $code ?? Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
