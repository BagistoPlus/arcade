@foreach ($order->refunds as $refund)
  <div class="mt-4">
    <h3 class="font-medium">
      {{ __('shop::app.customer.account.order.view.individual-refund', ['refund_id' => $refund->id]) }}
    </h3>

    <div class="mt-2">
      <table class="table-auto w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.SKU') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.product-name') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.price') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.qty') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.subtotal') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.tax-amount') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.grand-total') }}
            </th>
          </tr>
        </thead>

        <tbody>
          @forelse ($refund->items as $item)
            <tr>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.SKU') }}">
                {{ $item->child ? $item->child->sku : $item->sku }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.product-name') }}">
                {{ $item->name }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.price') }}">
                {{ core()->formatPrice($item->price, $order->order_currency_code) }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.qty') }}">
                {{ $item->qty }}</td>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.subtotal') }}">
                {{ core()->formatPrice($item->total, $order->order_currency_code) }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.tax-amount') }}">
                {{ core()->formatPrice($item->tax_amount, $order->order_currency_code) }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.grand-total') }}">
                {{ core()->formatPrice($item->total + $item->tax_amount, $order->order_currency_code) }}
              </td>
            </tr>
          @empty
            <tr>
              <td class="py-6 text-center empty" colspan="7">
                {{ __('shop::app.common.no-result-found') }}
              </td>
            <tr>
          @endforelse
        </tbody>
      </table>

      <div class="flex justify-end mt-4 totals">
          <table>
              <tr>
                  <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.subtotal') }}</td>
                  <td class="px-3 py-1 text-right">{{ core()->formatPrice($refund->sub_total, $order->order_currency_code) }}</td>
              </tr>

              @if ($refund->shipping_amount > 0)
                  <tr>
                      <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.shipping-handling') }}</td>
                      <td class="px-3 py-1 text-right">{{ core()->formatPrice($refund->shipping_amount, $order->order_currency_code) }}</td>
                  </tr>
              @endif

              @if ($refund->discount_amount > 0)
                  <tr>
                      <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.discount') }}</td>
                      <td class="px-3 py-1 text-right">{{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}</td>
                  </tr>
              @endif

              @if ($refund->tax_amount > 0)
                  <tr>
                      <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.tax') }}</td>
                      <td class="px-3 py-1 text-right">{{ core()->formatPrice($refund->tax_amount, $order->order_currency_code) }}</td>
                  </tr>
              @endif

              <tr>
                  <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.adjustment-refund') }}</td>
                  <td class="px-3 py-1 text-right">{{ core()->formatPrice($refund->adjustment_refund, $order->order_currency_code) }}</td>
              </tr>

              <tr>
                  <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.adjustment-fee') }}</td>
                  <td class="px-3 py-1 text-right">{{ core()->formatPrice($refund->adjustment_fee, $order->order_currency_code) }}</td>
              </tr>

              <tr class="bold">
                  <td class="px-3 py-1 text-left">{{ __('shop::app.customer.account.order.view.grand-total') }}</td>
                  <td class="px-3 py-1 text-right">{{ core()->formatPrice($refund->grand_total, $order->order_currency_code) }}</td>
              </tr>
          </table>
      </div>
    </div>
  </div>
@endforeach
