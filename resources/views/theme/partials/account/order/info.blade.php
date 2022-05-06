<div class="py-4">
  <div>
    <span class="title">
      {{ __('shop::app.customer.account.order.view.placed-on') }}
    </span>
    <span class="value">
      {{ core()->formatDate($order->created_at, 'd M Y') }}
    </span>
  </div>
  <div class="mt-4">
    <div class="mb-2 text-lg font-semibold border-b">
      <span>{{ __('shop::app.customer.account.order.view.products-ordered') }}</span>
    </div>
    <div>
      <table class="table-auto w-full divide-y">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.SKU') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.product-name') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.price') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.item-status') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.subtotal') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.tax-percent') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.tax-amount') }}</th>
            <th class="px-3 py-2 text-xs text-left">{{ __('shop::app.customer.account.order.view.grand-total') }}</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($order->items as $item)
            <tr>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.SKU') }}">
                {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.product-name') }}">
                {{ $item->name }}
                @if (isset($item->additional['attributes']))
                  <div class="item-options">
                    @foreach ($item->additional['attributes'] as $attribute)
                      <strong>{{ $attribute['attribute_name'] }} : </strong>{{ $attribute['option_label'] }}<br>
                    @endforeach
                  </div>
                @endif
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.price') }}">
                {{ core()->formatPrice($item->price, $order->order_currency_code) }}
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.item-status') }}">
                <div class="qty-row">
                  {{ __('shop::app.customer.account.order.view.item-ordered', ['qty_ordered' => $item->qty_ordered]) }}
                </div>

                <div class="qty-row">
                  {{ $item->qty_invoiced ? __('shop::app.customer.account.order.view.item-invoice', ['qty_invoiced' => $item->qty_invoiced]) : '' }}
                </div>

                <div class="qty-row">
                  {{ $item->qty_shipped ? __('shop::app.customer.account.order.view.item-shipped', ['qty_shipped' => $item->qty_shipped]) : '' }}
                </div>

                <div class="qty-row">
                  {{ $item->qty_refunded ? __('shop::app.customer.account.order.view.item-refunded', ['qty_refunded' => $item->qty_refunded]) : '' }}
                </div>

                <div class="qty-row">
                  {{ $item->qty_canceled ? __('shop::app.customer.account.order.view.item-canceled', ['qty_canceled' => $item->qty_canceled]) : '' }}
                </div>
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.subtotal') }}">
                {{ core()->formatPrice($item->total, $order->order_currency_code) }}
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.tax-percent') }}">
                {{ number_format($item->tax_percent, 2) }}%
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.tax-amount') }}">
                {{ core()->formatPrice($item->tax_amount, $order->order_currency_code) }}
              </td>

              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.grand-total') }}">
                {{ core()->formatPrice($item->total + $item->tax_amount - $item->discount_amount, $order->order_currency_code) }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="flex justify-end mt-4 totals">
        <table class="table w-full max-w-sm">
          <tbody>
            <tr>
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.subtotal') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}
              </td>
            </tr>

            @if ($order->haveStockableItems())
              <tr>
                <td class="px-3 py-1 text-left">
                  {{ __('shop::app.customer.account.order.view.shipping-handling') }}
                </td>
                <td class="px-3 py-1 text-right">
                  {{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}
                </td>
              </tr>
            @endif

            @if ($order->base_discount_amount > 0)
              <tr>
                <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.discount') }}
                  @if ($order->coupon_code)
                    ({{ $order->coupon_code }})
                  @endif
                </td>
                <td class="px-3 py-1 text-right">
                  {{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}
                </td>
              </tr>
            @endif

            <tr class="border-b">
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.tax') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($order->tax_amount, $order->order_currency_code) }}
              </td>
            </tr>

            <tr class="font-semibold">
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.grand-total') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}
              </td>
            </tr>

            <tr class="font-semibold">
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.total-paid') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($order->grand_total_invoiced, $order->order_currency_code) }}
              </td>
            </tr>

            <tr class="font-semibold">
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.total-refunded') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($order->grand_total_refunded, $order->order_currency_code) }}
              </td>
            </tr>

            <tr class="font-semibold">
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.total-due') }}
              </td>

              @if($order->status !== 'canceled')
                <td class="px-3 py-1 text-right">
                  {{ core()->formatPrice($order->total_due, $order->order_currency_code) }}
                </td>
              @else
                <td class="px-3 py-1 text-right">
                  {{ core()->formatPrice(0.00, $order->order_currency_code) }}
                </td>
              @endif
            </tr>
          <tbody>
        </table>
      </div>
    </div>
  </div>
</div>
