<?php

namespace Order\Payment;

class StripeGuzzleGateway
{
    private $apiKey;

    private $guzzleClient;

    public function __construct($apiKey, \GuzzleHttp\Client $httpClient)
    {
        $this->apiKey = $apiKey;

		$this->guzzleClient = $guzzleClient;
    }

    public function charge($amount, $token = 'tok_mastercard', $email = 'somebody@example.com')
    {
        try {
			$response = $this->guzzleClient->request('POST', 'https://api.stripe.com/v1/charges', [
				'auth' => [$this->apiKey, ''],
				'form_params' => [
					'amount' => $amount,
					'currency' => 'eur',
					'source' => $token,
					'description' => "Charge for $email"
				]
			]);

			$decoded = json_decode($response->getBody()->getContents(), true);

            return new Charge([
                'amount' => $decoded['amount'],
                'card_last_four' => $decoded['source']['last4']
            ]);
        }
    }
}
