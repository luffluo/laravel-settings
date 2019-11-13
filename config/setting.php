<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Setting Store
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'store'        => env('SETTING_STORE', 'json'),

    /*
    |--------------------------------------------------------------------------
    | JSON Store
    |--------------------------------------------------------------------------
    |
    | If the store is set to 'json', settings are stored in the defined
    | file path in JSON format. USe full path to file.
    |
    */
    'path'         => storage_path('app/settings.json'),

    /*
    |--------------------------------------------------------------------------
    | Database Store
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    // If set to null, the default connection will be used.
    'connection'   => env('SETTING_CONNECTION', null),

    // Name of the table used.
    'table'        => env('SETTING_TABLE', 'settings'),

    // Cache usage
    'enable_cache' => env('SETTING_ENABLE_CACHE', true),

    // Cache time for minutes
    'cache_ttl' => env('SETTING_CACHE_TTL', 15),

    'forget_cache_by_write' => env('SETTING_FORGET_CACHE_BY_WRITE', true),

    'key_column'   => env('SETTING_KEY_COLUMN', 'key'),
    'value_column' => env('SETTING_VALUE_COLUMN', 'value'),
];
