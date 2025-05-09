<?php
return [

    /*
     * Paths that are exempt from CORS checks.
     *
     * @example
     * 'paths' => ['api/*', 'sanctum/csrf-cookie'],
     */
    'paths' => ['api/*', 'broadcasting/auth'],

    /*
     * Allowed origins that may make requests.
     *
     * @example
     * 'allowed_origins' => ['http://yourdomain.com'],
     */
    'allowed_origins' => ['*'],

    /*
     * Allowed HTTP methods for API access.
     *
     * @example
     * 'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
     */
    'allowed_methods' => ['*'],

    /*
     * Allowed headers that may be sent in the request.
     *
     * @example
     * 'allowed_headers' => ['Content-Type', 'X-Auth-Token', 'Origin'],
     */
    'allowed_headers' => ['*'],

    /*
     * Exposed headers that are included in the response.
     *
     * @example
     * 'exposed_headers' => ['X-Content-Type-Options', 'X-RateLimit-Limit'],
     */
    'exposed_headers' => ['*'],

    /*
     * Max age for CORS cache (seconds)
     *
     * @example
     * 'max_age' => 60 * 60 * 12, // Cache for one hour
     */
    'max_age' => 0,

    /*
     * Supports credentials for cookies, authorization headers or other info-sharing methods.
     *
     * @example
     * 'supports_credentials' => true,
     */
    'supports_credentials' => false,

];
