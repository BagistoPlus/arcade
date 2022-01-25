<?php

namespace EldoMagan\BagistoArcade\Sections;

use Webkul\Checkout\Facades\Cart;

class CheckoutPage extends LivewireSection
{
    protected static $view = 'shop::sections.checkout-page';

    public $activeStep = 'information';

    public function isStepDone(string $step)
    {
        $steps = array_keys($this->steps());
        $currentStepIndex = array_search($this->activeStep, $steps);
        $stepIndex = array_search($step, $steps);

        return $stepIndex > $currentStepIndex;
    }

    public function isStepActive(string $step)
    {
        return $this->activeStep === $step;
    }

    public function steps()
    {
        return [
            'information' => [
                'icon' => 'heroicon-o-location-marker',
                'text' => __('shop::app.checkout.onepage.information'),
                'is_active' => true,
            ],
            'shipping' => [
                'icon' => 'gmdi-local-shipping-o',
                'text' => __('shop::app.checkout.onepage.shipping'),
                'is_active' => $this->isShippingActive(),
            ],
            'payment' => [
                'icon' => 'heroicon-o-credit-card',
                'text' => __('shop::app.checkout.onepage.payment'),
                'is_active' => true,
            ],
            'review' => [
                'icon' => 'heroicon-o-check',
                'text' => __('shop::app.checkout.onepage.review'),
                'is_active' => true,
            ],
        ];
    }

    public function isShippingActive()
    {
        return Cart::getCart()->haveStockableItems();
    }
}
