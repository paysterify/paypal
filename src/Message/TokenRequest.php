<?php

namespace Paysterify\Paypal\Message;

use Paysterify\Paypal\Message\AbstractRequest;

class TokenRequest extends AbstractRequest
{
    public function send()
    {
        $response = $this->httpClient->request('POST', $this->url('oauth2/token'), [
            'auth' => [
                $this->parameters['config']['client'],
                $this->parameters['config']['secret'],
            ],

            'headers' => [
                'content-type' => 'x-www-form-urlencoded',
            ],

            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
