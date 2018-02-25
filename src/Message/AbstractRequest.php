<?php

namespace Paysterify\Paypal\Message;

abstract class AbstractRequest extends \Paysterify\Message\AbstractRequest
{
    /**
     * Holding the paypal live API base url.
     *
     * @var string
     */
    const API_BASE_URL_LIVE = 'https://api.paypal.com/v1';

    /**
     * Holding the paypal sandbox API base url.
     *
     * @var string
     */
    const API_BASE_URL_SANDBOX = 'https://api.sandbox.paypal.com/v1';
}
