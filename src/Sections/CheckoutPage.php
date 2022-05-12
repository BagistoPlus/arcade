<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Data\Address;
use EldoMagan\BagistoArcade\Sections\Concerns\InteractsWithCart;
use EldoMagan\BagistoArcade\Sections\Concerns\InteractsWithCheckoutForm;

class CheckoutPage extends LivewireSection
{
    use InteractsWithCart;
    use InteractsWithCheckoutForm;

    /**
     * @var string rendered view
     */
    protected static string $view = 'shop::sections.checkout-page';

    protected $queryString = ['activeStep' => ['as' => 'step']];

    protected $listeners = ['couponApplied' => '$refresh'];

    public function mount()
    {
        $this->billingAddress = new Address();
        $this->shippingAddress = new Address();

        if ($this->isStepActive('shipping')) {
            $this->gotoShippingStep();
        } elseif ($this->isStepActive('payment')) {
            $this->gotoPaymentStep();
        }
    }
}
