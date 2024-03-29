<?php

namespace App\Http\Middleware;

use App\Exceptions\UnprocessableEntityException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $customRequest
     *
     * @return mixed
     */
    public function handle(
        Request $request,
        Closure $next,
        string $customRequest
    ) {
        $validator = Validator::make(
            $customRequest::data($request),
            $customRequest::rules()
        );

        throw_if(
            $validator->fails(),
            env('APP_DEBUG', false) ?
                new UnprocessableEntityException($validator->errors()) :
                UnprocessableEntityException::class
        );

        return $next($request);
    }
}
