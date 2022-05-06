@foreach ($order->shipments as $shipment)
  <div class="mt-4">
    <div>
      <span class="font-semibold">
        {{ __('shop::app.customer.account.order.view.tracking-number') }}:
      </span>

      <span class="value">
        {{  $shipment->track_number }}
      </span>
    </div>

    <div class="mt-2">
      <h3>
        {{ __('shop::app.customer.account.order.view.individual-shipment', ['shipment_id' => $shipment->id]) }}</>
      </h3>

      <table class="table-auto w-full mt-2">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.SKU') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.product-name') }}
            </th>
            <th class="px-3 py-2 text-xs text-left">
              {{ __('shop::app.customer.account.order.view.qty') }}
            </th>
          </tr>
        </thead>

        <tbody>
          @foreach ($shipment->items as $item)
            <tr>
              <td class="px-3 py-2 text-left" data-value="{{  __('shop::app.customer.account.order.view.SKU') }}">
                {{ $item->sku }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{  __('shop::app.customer.account.order.view.product-name') }}">
                {{ $item->name }}
              </td>
              <td class="px-3 py-2 text-left" data-value="{{  __('shop::app.customer.account.order.view.qty') }}">
                {{ $item->qty }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endforeach
