@props([
  'product' => null,
  'withAlpine' => true
])

<div
  @if($withAlpine)
    x-data="{
      prices: '{{ $product->getTypeInstance()->getPriceHtml() }}',
      init() {
        window.addEventListener('product-variant-change', (event) => {
          if (event.detail.variantPrice) {
            this.prices = event.detail.variantPrice.final_price.formated_price;
          }
        });
      }
    }"
  @endif
  {{ $attributes->merge(['class' => 'text-lg font-semibold text-primary']) }}
>
  {!! $product->getTypeInstance()->getPriceHtml() !!}
</div>
