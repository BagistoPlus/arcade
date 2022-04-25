<?php

namespace EldoMagan\BagistoArcade\Components;

use Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Livewire\Component;

class LoginCustomer extends Component
{
    public $email = '';
    public $password = '';

    public $redirectUrl = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        $this->redirectUrl = request()->get('redirect');
    }

    public function submit()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (! Auth::guard('customer')->attempt($credentials)) {
            session()->flash('error', trans('shop::app.customer.login-form.invalid-creds'));

            return;
        }

        $customer = Auth::guard('customer')->user();

        if ($customer->status == 0) {
            Auth::guard('customer')->logout();
            session()->flash('warning', trans('shop::app.customer.login-form.not-activated'));

            return;
        }

        if ($customer->is_verified == 0) {
            session()->flash('info', trans('shop::app.customer.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', $this->email, 1));

            Auth::guard('customer')->logout();

            return;
        }

        /**
         * Event passed to prepare cart after login.
         */
        Event::dispatch('customer.after.login', $this->email);

        return redirect()->intended($this->redirectUrl ?? route('customer.account.index'));
    }

    public function render()
    {
        return view('shop::components.login-customer');
    }
}
