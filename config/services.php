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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'passport' => [
        'login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
    ],
    
    'google' => [    
        'client_id' => '19503759575-80rbkahqo8bnrcpq7cnd6m9p559m4l2u.apps.googleusercontent.com',  
        'client_secret' => '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',  
        'redirect' => 'https://api.alakod.com/auth/callback'
      ],

      'googleApi' => [
        'client_id' => '289279522444-rol3v9jke2i6qmflmjfa8s9iuvprt3ol.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect_uri' => 'https://api.alakod.com/api/google/oauth',
        'webhook_uri' => 'https://api.alakod.com/api/google/webhook',
        'scopes' => [
            \Google_Service_Oauth2::USERINFO_EMAIL,
            \Google_Service_Calendar::CALENDAR,
        ],
        'approval_prompt' => 'force',
        'access_type' => 'offline',
        'include_granted_scopes' => true,
    ],

];
