<?php

namespace Paysterify\Paypal;

use Illuminate\Support\ServiceProvider;

class PaysterifyPaypalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('paysterify.paypal', function () {
            return new Gateway;
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
