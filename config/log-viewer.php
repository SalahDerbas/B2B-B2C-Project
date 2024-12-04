<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log Viewer route middleware.
    |--------------------------------------------------------------------------
    | The middleware should enable session and cookies support in order for the Log Viewer to work.
    | The 'web' middleware will be applied automatically if empty.
    |
    */

    'hosts' => [
        'local' => [
            'name' => 'Local',
            'host' => null,
        ],
        'staging' => [
            'name' => 'Staging server',
            'host' => env('STAGING_URL').'/log-viewer',
        ],
        'production' => [
            'name' => 'Production',
            'host' => env('PRODUCTION_URL').'/log-viewer',
        ],

        // add more hosts here
    ],

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Cache driver
    |--------------------------------------------------------------------------
    | Cache driver to use for storing the log indices. Indices are used to speed up
    | log navigation. Defaults to your application's default cache driver.
    |
    */
    'cache_driver' => env('LOG_VIEWER_CACHE_DRIVER', null),


    /*
    |--------------------------------------------------------------------------
    | Back to system URL
    |--------------------------------------------------------------------------
    | When set, displays a link to easily get back to this URL.
    | Set to `null` to hide this link.
    |
    | Optional label to display for the above URL.
    |
    */
    'back_to_system_url' => config('app.url', null),
    'back_to_system_label' => null,


];
