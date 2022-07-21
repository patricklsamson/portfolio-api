<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DBQueryLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!env('DB_QUERY_LOG', false)) {
            return $next($request);
        }

        DB::enableQueryLog();

        $response = $next($request);

        foreach (DB::getQueryLog() as $log) {
            $sql = $log['query'];

            foreach ($log['bindings'] as $binding) {
                $binding = is_numeric($binding) ? $binding : "'$binding'";
                $sql = preg_replace('/\\?/', $binding, $sql, 1);
            }

            Log::info(
                'DB QUERY LOG: ' . DB::connection()->getDatabaseName() .
                    PHP_EOL . 'PATH: ' . $request->getRequestUri() . PHP_EOL .
                    'QUERY:' . PHP_EOL . "$sql;" . str_repeat(PHP_EOL, 2) .
                    str_repeat('-', 80)
            );
        }

        return $response;
    }
}
