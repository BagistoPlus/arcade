<h2 class="text-2xl font-bold leading-tight">
  {{ __('shop::app.checkout.onepage.shipping-method') }}
</h2>

<div>
  @foreach($shippingRates as $key => $group)
    <div class="mt-4">
      {!! view_render_event('bagisto.shop.checkout.shipping-method.before', ['rateGroup' => $group]) !!}

      <h3 class="text-lg font-bold leading-tight">
        {{ $group['carrier_title'] }}
      </h3>

      @foreach($group['rates'] as $rate)
        <div class="mt-3">
          <label class="flex items-start">
            <input
              type="radio"
              name="shipping_method"
              value="{{ $rate['method'] }}"
              wire:model="selectedShippingMethod"
            >
            <div class="ml-2 -mt-1">
              <x-arcade::currency :amount="$rate['base_price']"/>
              <p>{{ $rate['method_title'] }}</p>
            </div>
          </label>
        </div>
      @endforeach

      {!! view_render_event('bagisto.shop.checkout.shipping-method.after', ['rateGroup' => $group]) !!}
    </div>
  @endforeach
</div>
