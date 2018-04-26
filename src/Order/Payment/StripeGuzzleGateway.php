<?php

namespace Order\Payment;

class StripeGuzzleGateway implements PaymentGateway
{
    private $apiKey;

    private $guzzleClient;

    public function __construct($apiKey, \GuzzleHttp\Client $guzzleClient)
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

            return new Charge($decoded['amount'], $decoded['source']['last4']);
        } catch (\Exception $e) {
            throw new PaymentFailedException;
        }
    }
}
