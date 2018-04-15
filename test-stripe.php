<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/src/app.php';

$client = new GuzzleHttp\Client();

$response = $client->request('POST', 'https://api.stripe.com/v1/charges', [
    'auth' => [$app['stripe.api_key', ''],
    'form_params' => [
        'amount' => 1500,
        'currency' => 'eur',
        'source' => 'tok_mastercard',
        'description' => 'Charge for somebody@example.com'
    ]
]);
$decoded = json_decode($response->getBody()->getContents(), true);
var_dump($decoded);
var_dump('amount: ' . $decoded['amount']);
var_dump('card last four: ' . $decoded['source']['last4']);

// curl https://api.stripe.com/v1/charges \
//    -u sk_test_2e4gg0eMZRZhgl0HY0wzguyD: \
//    -d amount=2000 \
//    -d currency=usd \
//    -d source=tok_mastercard \
//    -d description="Charge for mason.wilson@example.com"

