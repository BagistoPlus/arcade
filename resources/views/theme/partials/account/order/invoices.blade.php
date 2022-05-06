<div>
  @foreach ($order->invoices as $invoice)
    <div class="mb-6">
      <div class="flex justify-between mt-4">
        <h3 class="font-medium">
          {{ __('shop::app.customer.account.order.view.individual-invoice', ['invoice_id' => $invoice->increment_id ?? $invoice->id]) }}
        </h3>

        <a href="{{ route('customer.orders.print', $invoice->id) }}" class="text-primary hover:underline">
          {{ __('shop::app.customer.account.order.view.print') }}
        </a>
      </div>

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
            @foreach ($invoice->items as $item)
              <tr>
                <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.SKU') }}">
                  {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                </td>

                <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.product-name') }}">
                  {{ $item->name }}
                </td>

                <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.price') }}">
                  {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                </td>

                <td class="px-3 py-2 text-left" data-value="{{ __('shop::app.customer.account.order.view.qty') }}">
                  {{ $item->qty }}
                </td>

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
            @endforeach
          </tbody>
        </table>

        <div class="flex justify-end mt-4 totals">
          <table class="table-auto w-full max-w-sm">
            <tr>
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.subtotal') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($invoice->sub_total, $order->order_currency_code) }}
              </td>
            </tr>

            <tr>
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.shipping-handling') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($invoice->shipping_amount, $order->order_currency_code) }}
              </td>
            </tr>

            @if ($order->base_discount_amount > 0)
              <tr>
                <td class="px-3 py-1 text-left">
                  {{ __('shop::app.customer.account.order.view.discount') }}
                </td>
                <td class="px-3 py-1 text-right">
                  {{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}
                </td>
              </tr>
            @endif

            <tr>
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.tax') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($invoice->tax_amount, $order->order_currency_code) }}
              </td>
            </tr>

            <tr class="font-semibold">
              <td class="px-3 py-1 text-left">
                {{ __('shop::app.customer.account.order.view.grand-total') }}
              </td>
              <td class="px-3 py-1 text-right">
                {{ core()->formatPrice($invoice->grand_total, $order->order_currency_code) }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  @endforeach
</div>
