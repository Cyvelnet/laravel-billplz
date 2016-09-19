<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sandbox mode
    |--------------------------------------------------------------------------
    |
    | Enable sandbox mode and production configuration will not be apply.
    | Get your sandbox credential at https://billplz-staging.herokuapp.com
    |
    */
    'sandbox_mode' => env('BILLPLZ_ENABLE_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | Api key
    |--------------------------------------------------------------------------
    |
    | Obtains your api key by register account with www.billplz.com
    |
    */
    'api_key'      => [
        'production' => env('BILLPLZ_API_KEY', ''),
        'sandbox'    => env('BILLPLZ_SANDBOX_API_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Collection id
    |--------------------------------------------------------------------------
    |
    | Obtains your api key by register account with www.billplz.com
    |
    */

    'collection_id' => [
        'production' => env('BILLPLZ_COLLECTION_ID', ''),
        'sandbox'    => env('BILLPLZ_SANDBOX_COLLECTION_ID', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Reference
    |--------------------------------------------------------------------------
    |
    | Default references to issues a bill
    |
    */

    'references' => [
        [
            'label'     => 'Reference 1', // max 120 characters
            'reference' => '', // max 20 characters
        ],
        [
            'label'     => 'Reference 2', // max 120 characters
            'reference' => '', // max 20 characters
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | The default logo for creating new billplz collection
    | Supported format:  jpg, jpeg, gif and png only
    */
    'logo'       => '', // storage_path('/billplz/my-logo.jpg')

    /*
    |--------------------------------------------------------------------------
    | Photo
    |--------------------------------------------------------------------------
    |
    | The default photo for creating a new billplz open collection
    | Supported format:  jpg, jpeg, gif and png only
    */
    'photo'      => '', // storage_path('/billplz/my-photo.jpg')

    /*
    |--------------------------------------------------------------------------
    | Bill generation location
    |--------------------------------------------------------------------------
    |
    | The default bill store location relative to App/
    */
    'directory'  => 'Bills\\',

    /*
    |--------------------------------------------------------------------------
    | Bill generation namespace
    |--------------------------------------------------------------------------
    |
    | The default bill store namespace
    */
    'namespace'  => 'App/Bills',
];
