<h2 class="text-2xl font-bold leading-tight">
  {{ __('shop::app.checkout.onepage.summary') }}
</h2>

<div class="mt-4">
  <div class="flex flex-wrap border border-gray-300 divide-gray-300 md:divide-x">
    @if ($billingAddress = $cart->billing_address)
      <div class="w-full p-6 md:flex-1">
        <h3 class="font-semibold uppercase text-md">
          {{ __('shop::app.checkout.onepage.billing-address') }}
        </h3>
        <div class="mt-2">
          <p>{{ $billingAddress->company_name ?? '' }}</p>
          <p class="font-semibold">
            {{ $billingAddress->first_name }} {{ $billingAddress->last_name }}
          </p>
          <p>{{ $billingAddress->address1 }}, {{ $billingAddress->state }}</p>
          <p>{{ $billingAddress->postcode }} {{ $billingAddress->city }}</p>
          <p>{{ core()->country_name($billingAddress->country) }}</p>
          <p>{{ $billingAddress->phone }}</p>
        </div>
      </div>
    @endif

    @if ($cart->haveStockableItems() && $shippingAddress = $cart->shipping_address)
      <div class="w-full p-6 md:flex-1">
        <h3 class="font-semibold uppercase text-md">
          {{ __('shop::app.checkout.onepage.shipping-address') }}
        </h3>
        <div class="mt-2">
          <p>{{ $shippingAddress->company_name ?? '' }}</p>
          <p class="font-semibold">
            {{ $shippingAddress->first_name }} {{ $shippingAddress->last_name }}
          </p>
          <p>{{ $shippingAddress->address1 }}, {{ $shippingAddress->state }}</p>
          <p>{{ $shippingAddress->postcode }} {{ $shippingAddress->city }}</p>
          <p>{{ core()->country_name($shippingAddress->country) }}</p>
          <p>{{ $shippingAddress->phone }}</p>
        </div>
      </div>
    @endif
  </div>

  <div class="px-4 py-2 mt-4 space-y-2 border border-gray-300 divide-gray-300 md:divide-y">
    @if ($cart->haveStockableItems())
      <div class="grid grid-cols-4 py-1">
        <div class="text-gray-600">
          {{ __('shop::app.checkout.onepage.shipping') }}
        </div>
        <div class="col-span-2">
          {{ $cart->selected_shipping_rate->method_title }}
        </div>
        <div class="font-medium text-right text-secondary">
          {{ core()->currency($cart->selected_shipping_rate->base_price) }}
        </div>
      </div>
    @endif

    <div class="grid grid-cols-4 py-1 pt-2">
      <div class="text-gray-600">
        {{ __('shop::app.checkout.onepage.payment-method') }}
      </div>
      <div class="col-span-2">
        {{ core()->getConfigData('sales.paymentmethods.' . $cart->payment->method . '.title') }}
      </div>
    </div>
  </div>

  <div class="mt-4">
    <h3 class="text-lg font-semibold">
      {{ __('shop::app.minicart.cart') }}
    </h3>

    <div class="mt-2 overflow-hidden border border-gray-300 divide-y divide-gray-300">
      @foreach ($this->cartItems as $item)
        <div class="flex items-center p-2">
          <div class="flex-none w-24">
            <div class="relative pb-[100%] overflow-hidden border">
              <img alt="{{ $item->name }}" src="{{ $item->smallImage }}" class="absolute object-cover w-full h-full">
            </div>
          </div>
          <div class="flex-1 ml-4">
            {!! view_render_event('bagisto.shop.checkout.name.before', ['item' => $item]) !!}

            <div class="mt-1">
              <a
                href="{{ route('shop.productOrCategory.index', $item->product->url_key) }}"
                class="font-semibold hover:text-secondary hover:font-bold"
              >
                {{ $item->name }}
              </a>
            </div>

            {!! view_render_event('bagisto.shop.checkout.name.after', ['item' => $item]) !!}
            {!! view_render_event('bagisto.shop.checkout.price.before', ['item' => $item]) !!}

            <div class="font-bold text-secondary">
              <x-arcade::currency :amount="$item->base_price" />
            </div>

            {!! view_render_event('bagisto.shop.checkout.price.after', ['item' => $item]) !!}
            {!! view_render_event('bagisto.shop.checkout.quantity.before', ['item' => $item]) !!}

            <div>
              {{ __('shop::app.checkout.onepage.quantity') }}: {{ $item->quantity }}
            </div>

            {!! view_render_event('bagisto.shop.checkout.quantity.after', ['item' => $item]) !!}
            {!! view_render_event('bagisto.shop.checkout.options.before', ['item' => $item]) !!}

            @if (isset($item->additional['attributes']))
              <div class="item-options">

                @foreach ($item->additional['attributes'] as $attribute)
                  <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                @endforeach

              </div>
            @endif

            {!! view_render_event('bagisto.shop.checkout.options.after', ['item' => $item]) !!}
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="mt-4">
    @php
      $checkoutButtons = view_render_event(
        'bagisto.shop.checkout.payment.' . $cart->payment->method,
        ['cart' => $cart]
      );
    @endphp

    @if ($checkoutButtons)
      {!! $checkoutButtons !!}
    @else
      <div class="text-center">
        <button
          type="submit"
          class="bg-primary text-white py-3 px-6 focus:outline-none focus:shadow-outline"
          wire:click="placeOrder"
        >
          {{ __('shop::app.checkout.onepage.place-order') }}
        </button>
      </div>
    @endif
  </div>
</div>

<script type="text/javascript">
  // On direct page reload, make sure to dispatch checkout.payment event
  window.addEventListener('load', function () {
    window.dispatchEvent(new CustomEvent('checkout.payment', {
      detail: {
        paymentMethod:'{{ $cart->payment->method }}'
      }
    }))
  });
</script>
