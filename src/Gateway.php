<?php

namespace Paysterify\Paypal;

use Paysterify\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * Authorize the gateway.
     *
     * @return Paysterify
     */
    public function authorize()
    {
        $response = $this->request('\Paysterify\Paypal\Message\TokenRequest', [
            'config' => $this->config,
        ]);

        return $response;
    }

    /**
     * Perform the payment request.
     *
     * @return Paysterify
     */
    public function purchase()
    {
        $access_token = $this->authorize()->access_token;

        $response = $this->request('\Paysterify\Paypal\Message\PurchaseRequest', [
            'access_token' => $access_token,
            'config' => $this->config,
        ]);

        return $response;
    }

    /**
     * Set the gateway config.
     *
     * @return \Paysterify\Paypal\Gateway
     */
    public function configure(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Assert if the gateway requires a redirect.
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Redirect the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return redirect($this->response->links[1]->href)->send();
    }

    /**
     * Perform a complete purchase request.
     *
     * @param  array $params
     * @return Paysterify
     */
    public function completePurchase($params)
    {
        $access_token = $this->authorize()->access_token;

        $response = $this->request('\Paysterify\Paypal\Message\CompletePurchaseRequest', [
            'access_token' => $access_token,
            'payerId' => $params['payerId'],
            'paymentId' => $params['paymentId'],
            'config' => $this->config,
        ]);

        return $response;
    }

    /**
     * Assert if the payment is completed.
     *
     * @return boolean
     */
    public function isCompleted()
    {
        $sale = $this->response->transactions[0]->related_resources[0]->sale;

        return $sale->state === 'completed';
    }

    /**
     * Retrive the paid amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->response->transactions[0]->amount->total;
    }

    /**
     * Retrive the paid amount currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->response->transactions[0]->amount->currency;
    }
}
