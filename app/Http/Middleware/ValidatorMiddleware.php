<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class ValidatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $customRequest)
    {
        $validator = Validator::make(
            $customRequest::data($request),
            $customRequest::rules($request)
        );

        $validator->validated();

        return $next($request);
    }
}
