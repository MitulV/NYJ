<?php

return [
    'api_keys' => [
        'secret_key' => env('STRIPE_SECRET_KEY', null),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', null)
    ],
    'client_id' => env('STRIPE_CLIENT_ID', null),       // Client ID: https://dashboard.stripe.com/account/applications/settings
    'redirect_uri' => env('STRIPE_REDIRECT_URI', null), // Redirect Uri https://dashboard.stripe.com/account/applications/settings
    'authorization_uri' => 'https://connect.stripe.com/oauth/authorize'
];