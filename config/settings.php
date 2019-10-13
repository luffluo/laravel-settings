<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Settings Store
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'store' => 'json',

    /*
    |--------------------------------------------------------------------------
    | JSON Store
    |--------------------------------------------------------------------------
    |
    | If the store is set to 'json', settings are stored in the defined
    | file path in JSON format. USe full path to file.
    |
    */
    'path' => storage_path('app/settings.json'),

    /*
    |--------------------------------------------------------------------------
    | Redis
    |--------------------------------------------------------------------------
    | If the store is set to 'redis'
    | Redis setting
    |
    */
    'redis' => [

        // Redis hash name
        'hash_name' => env('SETTINGS_REDIS_HASH_NAME', 'settings')
    ]
];
