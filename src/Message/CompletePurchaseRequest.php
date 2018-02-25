<?php

namespace Paysterify\Paypal\Message;

use Paysterify\Paypal\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest
{
    public function send()
    {
        $response = $this->httpClient->request('POST', $this->url('payments/payment/'.$this->parameters['paymentId'].'/execute'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->parameters['access_token'],
                'Content-Type' => 'application/json',
            ],

            'json' => [
                'payer_id' => $this->parameters['payerId'],
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
