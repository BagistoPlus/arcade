<div>
  <h3 class="text-lg font-medium">{{ __('shop::app.checkout.total.order-summary') }}</h3>

  <div class="flex justify-between mt-4">
    <label>
      {{ intval($cart->items_qty) }}
      {{ __('shop::app.checkout.total.sub-total') }}
      {{ __('shop::app.checkout.total.price') }}
    </label>
    <label>{{ core()->currency($cart->base_sub_total) }}</label>
  </div>

  @if ($cart->selected_shipping_rate)
    <div class="flex justify-between mt-2">
      <label>{{ __('shop::app.checkout.total.delivery-charges') }}</label>
      <label>{{ core()->currency($cart->selected_shipping_rate->base_price) }}</label>
    </div>
  @endif

  @if ($cart->base_tax_total)
    @foreach (Webkul\Tax\Helpers\Tax::getTaxRatesWithAmount($cart, true) as $taxRate => $baseTaxAmount )
      <div class="flex justify-between mt-2">
          <label id="taxrate-{{ core()->taxRateAsIdentifier($taxRate) }}">
            {{ __('shop::app.checkout.total.tax') }} {{ $taxRate }} %
          </label>
          <label id="basetaxamount-{{ core()->taxRateAsIdentifier($taxRate) }}">
            {{ core()->currency($baseTaxAmount) }}
          </label>
      </div>
    @endforeach
  @endif

  @if ($cart->base_discount_amount && $cart->base_discount_amount > 0)
    <div class="flex justify-between mt-2">
      <label>
        {{ __('shop::app.checkout.total.disc-amount') }}
      </label>
      <label class="right">
        -{{ core()->currency($cart->base_discount_amount) }}
      </label>
    </div>
  @endif

  <hr class="border-gray-300 my-3">

  <div class="font-semibold flex justify-between">
    <label>{{ __('shop::app.checkout.total.grand-total') }}</label>
    <label>
      {{ core()->currency($cart->base_grand_total) }}
    </label>
  </div>
</div>
