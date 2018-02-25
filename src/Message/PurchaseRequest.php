<?php

namespace Paysterify\Paypal\Message;

use Paysterify\Paypal\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    public function send()
    {
        $response = $this->httpClient->request('POST', $this->url('payments/payment'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->parameters['access_token'],
                'Content-Type' => 'application/json',
            ],

            'json' => [
                'intent' => 'sale',

                'payer' => [
                    'payment_method' => 'paypal',
                ],

                'redirect_urls' => [
                    'return_url' => $this->parameters['config']['url_return'],
                    'cancel_url' => $this->parameters['config']['url_cancel'],
                ],

                'transactions' => [
                    [
                        'amount' => [
                            'total' => $this->parameters['config']['amount'],
                            'currency' => $this->parameters['config']['currency'],
                        ],

                        'item_list' => [
                            'items' => [
                                [
                                    'quantity' => '1',
                                    'description' => isset($this->parameters['config']['description']) ? $this->parameters['config']['description'] : '',
                                    'price' => $this->parameters['config']['amount'],
                                    'currency' => $this->parameters['config']['currency'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
