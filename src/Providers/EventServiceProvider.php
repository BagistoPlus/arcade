<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\Listeners\SendCustomerWelcomeEmail;
use EldoMagan\BagistoArcade\Listeners\SendCustomerVerificationEmail;
use EldoMagan\BagistoArcade\Listeners\SubscribeCustomerToNewsletter;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'customer.registration.after' => [
            SubscribeCustomerToNewsletter::class,
            SendCustomerWelcomeEmail::class,
            SendCustomerVerificationEmail::class
        ],
    ];
}
