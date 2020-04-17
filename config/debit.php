<?php

return [
    'name' => 'Débito - Pagamento na Entrega',
    'description' => 'Débito -Pagamento na Entrega',
    'account_id' => env('PP_ACCOUNT_ID', 'xxxx'),
    'client_id' => env('PP_CLIENT_ID', 'xxxx'),
    'client_secret' => env('PP_CLIENT_SECRET', 'xxxx'),
    'api_url' => env('PP_API_URL', 'https://api.sandbox.paypal.com'),
    'redirect_url' => env('PP_REDIRECT_URL', 'xxxx'),
    'cancel_url' => env('PP_CANCEL_URL', 'xxxx'),
    'failed_url' => env('PP_FAILED_URL', 'xxxx'),
    'mode' => env('PP_MODE', 'xxxx'),
    'note' => env('DEBIT_PAY_ON_DELIVERY_NOTE', 'Choosing this option may delay the shipment of the item.')
];