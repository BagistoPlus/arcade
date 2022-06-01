@props([
  'product' => null
])


@php
  $this->setData(
    'qty',
    $product->groupedProductsBySortOrder
      ->groupBy->associated_product_id
      ->map(function ($items) {
        return $items[0]->qty;
      })
      ->sortBy(function($item, $key) {
        return $key;
      })->toArray()
  );
@endphp

@if ($product->groupedProductsBySortOrder->count())

  <div class="divide-y my-4">
    <div class="flex justify-between">
      <span class="font-medium">{{ __('shop::app.products.name') }}</span>
      <span class="font-medium">{{ __('shop::app.products.qty') }}</span>
    </div>

    @foreach ($product->groupedProductsBySortOrder as $groupedProduct)
      @if($groupedProduct->associated_product->getTypeInstance()->isSaleable())
        <div class="flex justify-between py-2">
          <div>
            <span>{{ $groupedProduct->associated_product->name }}</span>
            <x-product-price
              :product="$groupedProduct->associated_product"
              class="!text-base !text-gray-700"
            />
          </div>
          <x-arcade::quantity-selector
            class="mb-4"
            :value="$groupedProduct->qty"
            wire:on-input="$set('data.qty.' + {{ $groupedProduct->associated_product_id }}, $event.detail, true)"
          />
        </div>
      @endif
    @endforeach
  </div>
@endif
