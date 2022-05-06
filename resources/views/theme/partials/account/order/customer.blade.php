<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
  <div class="box">
    <div class="font-semibold">
      {{ __('shop::app.customer.account.order.view.billing-address') }}
    </div>

    <div class="box-content">
      @include ('admin::sales.address', ['address' => $order->billing_address])

      {!! view_render_event('bagisto.shop.customers.account.orders.view.billing-address.after', ['order' => $order]) !!}
    </div>
  </div>

  @if ($order->shipping_address)
    <div class="box">
      <div class="font-semibold">
          {{ __('shop::app.customer.account.order.view.shipping-address') }}
      </div>

      <div class="box-content">
        @include ('admin::sales.address', ['address' => $order->shipping_address])

        {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping-address.after', ['order' => $order]) !!}
      </div>
    </div>

    <div class="box">
      <div class="font-semibold">
        {{ __('shop::app.customer.account.order.view.shipping-method') }}
      </div>

      <div class="box-content">
        {{ $order->shipping_title }}

        {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping-method.after', ['order' => $order]) !!}
      </div>
    </div>
  @endif

  <div class="box">
    <div class="font-semibold">
      {{ __('shop::app.customer.account.order.view.payment-method') }}
    </div>

    <div class="box-content">
      {{ core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title') }}

      @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($order->payment->method); @endphp

      @if (! empty($additionalDetails))
        <div class="instructions">
          <label>{{ $additionalDetails['title'] }}</label>
          <p>{{ $additionalDetails['value'] }}</p>
        </div>
      @endif

      {!! view_render_event('bagisto.shop.customers.account.orders.view.payment-method.after', ['order' => $order]) !!}
    </div>
  </div>
</div>
