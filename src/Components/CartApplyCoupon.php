<?php

namespace EldoMagan\BagistoArcade\Components;

use Livewire\Component;
use Webkul\Checkout\Facades\Cart;

class CartApplyCoupon extends Component
{
    public $code = '';

    public function booted()
    {
        $this->code = Cart::getCart()->coupon_code;
    }

    public function submit()
    {
        if (empty($this->code)) {
            $this->addError('code', __('shop::app.checkout.total.invalid-coupon'));
            return;
        }

        try {
            Cart::setCouponCode($this->code)->collectTotals();
            $this->emit('couponApplied');

            if (Cart::getCart()->coupon_code === $this->code) {
                return session()->flash('message', __('shop::app.checkout.total.success-coupon'));
            }

            $this->addError('code', __('shop::app.checkout.total.coupon-apply-issue'));
        } catch (\Exception $e) {
            report($e);
            $this->addError('code', __('shop::app.checkout.total.coupon-apply-issue'));
        }
    }

    public function render()
    {
        return view('shop::components.cart-apply-coupon');
    }
}
