<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => '1497189624065131',  //client face của bạn
        'client_secret' => '555740cf42fcebeb3f489a38ecc49009',  //client app service face của bạn
        'redirect' => 'https://dev.test/admin/callback' //callback trả về
    ],
    'google' => [
        'client_id' => '319579800844-dilv7cuh76cnl08uapb7i54tsba8pqbm.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/codelove/shopping-happy-main/public/google/callback'
    ],



];
