<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Options
    |--------------------------------------------------------------------------
    |
    | The allowed_methods and allowed_headers options are case-insensitive.
    |
    | You don't need to provide both allowed_origins and
    | allowed_origins_patterns. If one of the strings passed matches, it is
    | considered a valid origin.
    |
    | If ['*'] is provided to allowed_methods, allowed_origins or
    | allowed_headers all methods / origins / headers are allowed.
    |
    */

    /*
     * You can enable CORS for 1 or multiple paths.
     * Example: ['api/*']
     */
    'paths' => json_decode(env('CORS_PATHS')),

    /*
    * Matches the request method. `['*']` allows all methods.
    */
    'allowed_methods' => json_decode(env('CORS_ALLOWED_METHODS')),

    /*
     * Matches the request origin. `['*']` allows all origins. Wildcards can be
     * used, eg `*.mydomain.com`
     */
    'allowed_origins' => json_decode(env('CORS_ALLOWED_ORIGINS')),

    /*
     * Patterns that can be used with `preg_match` to match the origin.
     */
    'allowed_origins_patterns' => json_decode(
        env('CORS_ALLOWED_ORIGINS_PATTERNS')
    ),

    /*
     * Sets the Access-Control-Allow-Headers response header. `['*']` allows all
     * headers.
     */
    'allowed_headers' => json_decode(env('CORS_ALLOWED_HEADERS')),

    /*
     * Sets the Access-Control-Expose-Headers response header with these
     * headers.
     */
    'exposed_headers' => json_decode(env('CORS_EXPOSED_HEADERS')),

    /*
     * Sets the Access-Control-Max-Age response header when > 0.
     */
    'max_age' => 0,

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'supports_credentials' => true,
];
