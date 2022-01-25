<div class="max-w-2xl">
  @guest('customer')
    <p class="mb-4">
      Vous avez un compte ?
      <a href="{{ route('customer.session.index', ['redirect' => route('shop.checkout.onepage.index')]) }}" class="underline text-primary">
        Connectez-vous.
      </a>
    </p>
  @endguest

  <form method="post">
    <x-checkout-address-form
      name="billing"
      new-form-toggle="showNewBillingAddressForm"
      :cart="$cart"
      :addresses="$this->customerAddresses"
      :title="__('shop::app.checkout.onepage.billing-address')"
    />

    @if(!$billingAddress->use_for_shipping && $cart->haveStockableItems())
      <hr class="my-6 border-gray-300">
      <x-checkout-address-form
        name="shipping"
        new-form-toggle="showNewShippingAddressForm"
        :cart="$cart"
        :addresses="$this->customerAddresses"
        :title="__('shop::app.checkout.onepage.shipping-address')"
      />
    @endif
  </form>
</div>
