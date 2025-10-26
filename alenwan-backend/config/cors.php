<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Cross-Origin Resource Sharing (CORS) Configuration
     |--------------------------------------------------------------------------
     */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => env('APP_ENV') === 'production'
        ? explode(',', env('CORS_ALLOWED_ORIGINS', 'https://yourdomain.com'))
        : ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['X-Total-Count', 'X-Page-Count'],

    'max_age' => env('CORS_MAX_AGE', 86400),

    'supports_credentials' => true,
];