<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'firebase' => [
        'api_key' => 'AIzaSyD0VQd87qMeBpne_8Oki_BK7az_lCS1j0o', //  used for JS integration
        'auth_domain' => 'nomada-7f903.firebaseapp.com', // used for JS integration
        'database_url' => 'https://nomada-7f903.firebaseio.com',
        'secret' => 'secret',
        'storage_bucket' => 'nomada-7f903.appspot.com', // used for JS integration
    ], 
];
