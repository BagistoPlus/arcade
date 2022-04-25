<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use EldoMagan\BagistoArcade\Actions\Checkout\SavePaymentMethod;
use EldoMagan\BagistoArcade\Actions\Checkout\SaveShippingMethod;
use EldoMagan\BagistoArcade\Actions\Checkout\StoreCustomerAddresses;
use EldoMagan\BagistoArcade\Data\Address;
use EldoMagan\BagistoArcade\Exceptions\InvalidCartException;
use EldoMagan\BagistoArcade\Exceptions\InvalidGuestCheckoutException;

use Illuminate\Support\Str;

use Webkul\Checkout\Facades\Cart;
use Webkul\Payment\Facades\Payment;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Shop\Http\Controllers\OnepageController;

trait InteractsWithCheckoutForm
{
    /**
     * @var string active checkout step
     */
    public $activeStep = 'information';

    public $showNewBillingAddressForm = false;

    public $showNewShippingAddressForm = false;

    /**
     * @var Address customer checkout billing address data
     */
    public Address $billingAddress;

    /**
     * @var Address customer checkout shipping address data
     */
    public Address $shippingAddress;

    /**
     * @var string selected checkout shipping method
     */
    public $selectedShippingMethod;

    /**
     * @var string selected checkout payment method
     */
    public $selectedPaymentMethod;

    /**
     * @var array available checkout shipping methods
     */
    public $shippingRates = [];

    /**
     * @var array available checkout payment methods
     */
    public $paymentMethods = [];

    public function mountInteractsWithCheckoutForm()
    {
        $this->showNewBillingAddressForm = count($this->getCustomerAddressesProperty()) === 0;
        $this->showNewShippingAddressForm = $this->showNewBillingAddressForm;
    }

    public function getCustomerAddressesProperty()
    {
        if (! auth()->guard('customer')->check()) {
            return [];
        }

        return auth()->guard('customer')->user()->addresses;
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

    public function isStepDone(string $step)
    {
        $steps = array_keys($this->steps());
        $currentStepIndex = array_search($this->activeStep, $steps);
        $stepIndex = array_search($step, $steps);

        return $stepIndex < $currentStepIndex;
    }

    public function isStepActive(string $step)
    {
        return $this->activeStep === $step;
    }

    public function goToStep(string $step)
    {
        if ($this->isStepDone($step)) {
            $this->activeStep = $step;
        }
    }

    protected function gotoShippingStep()
    {
        Shipping::collectRates();

        $this->shippingRates = Shipping::getGroupedAllShippingRates();

        if (($firstGroup = reset($this->shippingRates)) && ! empty($firstGroup['rates'])) {
            $this->selectedShippingMethod = $firstGroup['rates'][0]['method'];
        }

        $this->activeStep = 'shipping';
    }

    protected function gotoPaymentStep()
    {
        $this->paymentMethods = Payment::getPaymentMethods();

        if (! empty($this->paymentMethods)) {
            $this->selectedPaymentMethod = $this->paymentMethods[0]['method'];
        }

        $this->activeStep = 'payment';
    }

    public function submit()
    {
        $method = 'submit' . Str::studly($this->activeStep);

        if (method_exists($this, $method)) {
            $this->{$method}();
        }
    }

    public function submitInformation()
    {
        $this->validate(
            array_merge(
                $this->getBillingAddressValidationRules(),
                $this->getShippingAddressValidationRules()
            ),
            [],
            array_merge(
                $this->getAddressValidationAttributes('billing'),
                $this->getAddressValidationAttributes('shipping')
            )
        );

        try {
            resolve(StoreCustomerAddresses::class)([
                'billing' => $this->billingAddress->toExpectedArray(),
                'shipping' => $this->shippingAddress->toExpectedArray(),
            ]);
        } catch (InvalidCartException $e) {
            dd('InvalidCartException');

            return $this->redirectRoute('shop.checkout.cart.index');
        } catch (InvalidGuestCheckoutException $e) {
            dd('InvalidGuestCheckoutException');

            return $this->redirectRoute('customer.session.index');
        }

        if ($this->isShippingActive()) {
            return $this->gotoShippingStep();
        } else {
            return $this->gotoPaymentStep();
        }
    }

    public function submitShipping()
    {
        try {
            resolve(SaveShippingMethod::class)($this->selectedShippingMethod);
        } catch (InvalidCartException $e) {
            return $this->redirectRoute('shop.checkout.cart.index');
        }

        $this->emit('cartUpdated');
        $this->gotoPaymentStep();
    }

    public function submitPayment()
    {
        $this->validateOnly(
            'selectedPaymentMethod',
            ['selectedPaymentMethod' => 'required'],
            [],
            ['selectedPaymentMethod' => __('shop::app.checkout.onepage.payment-method')]
        );

        try {
            resolve(SavePaymentMethod::class)($this->selectedPaymentMethod);
        } catch (InvalidCartException $e) {
            return $this->redirectRoute('shop.checkout.cart.index');
        }

        $this->activeStep = 'review';
        $this->dispatchBrowserEvent('checkout.payment', [
            'paymentMethod' => $this->selectedPaymentMethod,
        ]);
    }

    public function placeOrder()
    {
        try {
            $responseData = resolve(OnepageController::class)->saveOrder()->getData();

            if (isset($responseData->redirect_url)) {
                return $this->redirectTo($responseData->redirect_url);
            }

            return $this->redirectRoute('shop.checkout.success');
        } catch (\Exception $e) {
            // Notify user about the exception
            return $this->redirectRoute('shop.checkout.cart.index');
        }
    }

    protected function getBillingAddressValidationRules()
    {
        if (! $this->showNewBillingAddressForm) {
            return [
                'billingAddress.address_id' => 'required',
            ];
        }

        $rules = [
            'billingAddress.first_name' => 'required',
            'billingAddress.last_name' => 'required',
            'billingAddress.email' => 'required|email',
            'billingAddress.phone' => 'required|numeric',
            'billingAddress.address1.0' => 'required',
            'billingAddress.city' => 'required',
        ];

        if (true/* core()->getConfigData('customer.settings.address.country_required') */) {
            $rules['billingAddress.country'] = 'required';
        }

        if (true/* core()->getConfigData('customer.settings.address.state_required') */) {
            $rules['billingAddress.state'] = 'required';
        }

        if (true/* core()->getConfigData('customer.settings.address.postcode_required') */) {
            $rules['billingAddress.postcode'] = 'required';
        }

        return $rules;
    }

    protected function getShippingAddressValidationRules()
    {
        if ($this->billingAddress->use_for_shipping) {
            return [];
        }

        if (! $this->showNewShippingAddressForm) {
            return [
                'shippingAddress.address_id' => 'required',
            ];
        }

        $rules = [
            'shippingAddress.first_name' => 'required',
            'shippingAddress.last_name' => 'required',
            'shippingAddress.email' => 'required|email',
            'shippingAddress.phone' => 'required|numeric',
            'shippingAddress.address1.0' => 'required',
            'shippingAddress.city' => 'required',
        ];

        return $rules;
    }

    protected function getAddressValidationAttributes($addressType = 'billing')
    {
        return [
            $addressType . 'Address.first_name' => __('shop::app.checkout.onepage.first-name'),
            $addressType . 'Address.last_name' => __('shop::app.checkout.onepage.last-name'),
            $addressType . 'Address.email' => __('shop::app.checkout.onepage.email'),
            $addressType . 'Address.phone' => __('shop::app.checkout.onepage.phone'),
            $addressType . 'Address.address1.0' => __('shop::app.checkout.onepage.address1'),
            $addressType . 'Address.city' => __('shop::app.checkout.onepage.city'),
            $addressType . 'Address.country' => __('shop::app.checkout.onepage.country'),
            $addressType . 'Address.state' => __('shop::app.checkout.onepage.state'),
            $addressType . 'Address.postcode' => __('shop::app.checkout.onepage.postcode'),
            $addressType . 'Address.address_id' => __('shop::app.checkout.onepage.' . $addressType . '-address'),
        ];
    }
}
