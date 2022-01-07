<?php

namespace EldoMagan\BagistoArcade\Listeners;

use Illuminate\Support\Facades\Mail;
use Webkul\Customer\Mail\VerificationEmail;

class SendCustomerVerificationEmail
{
    public function handle($customer)
    {
        if (! core()->getConfigData('customer.settings.email.verification')) {
            return;
        }

        try {
            if (core()->getConfigData('emails.general.notifications.emails.general.notifications.verification')) {
                Mail::queue(new VerificationEmail([
                    'email' => $customer->email,
                    'token' => $customer->token,
                ]));
            }

            session()->flash('success', trans('shop::app.customer.signup-form.success-verify'));
        } catch (\Exception $e) {
            report($e);

            session()->flash('info', trans('shop::app.customer.signup-form.success-verify-email-unsent'));
        }
    }
}
