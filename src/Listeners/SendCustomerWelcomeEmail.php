<?php

namespace EldoMagan\BagistoArcade\Listeners;

use Illuminate\Support\Facades\Mail;
use Webkul\Customer\Mail\RegistrationEmail;

class SendCustomerWelcomeEmail
{
    public function handle($customer)
    {
        if (core()->getConfigData('customer.settings.email.verification')) {
            return;
        }

        try {
            if (core()->getConfigData('emails.general.notifications.emails.general.notifications.registration')) {
                Mail::queue(new RegistrationEmail($customer->toArray(), 'customer'));
            }

            if (core()->getConfigData('emails.general.notifications.emails.general.notifications.customer-registration-confirmation-mail-to-admin')) {
                Mail::queue(new RegistrationEmail($customer->toArray(), 'admin'));
            }

            session()->flash('success', trans('shop::app.customer.signup-form.success-verify'));
        } catch (\Exception $e) {
            report($e);

            session()->flash('info', trans('shop::app.customer.signup-form.success-verify-email-unsent'));
        }

        session()->flash('success', trans('shop::app.customer.signup-form.success'));
    }
}
