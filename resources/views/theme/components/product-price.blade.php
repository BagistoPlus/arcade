@props([
  'product' => null,
  'withAlpine' => true
])

<div
  @if($withAlpine)
    x-data="{
      price: '{{ $product->getTypeInstance()->getPriceHtml() }}',
      init() {
        window.addEventListener('product-variant-change', (event) => {
          console.log(event.detail);
          if (event.detail.variantPrice) {
            this.price = event.detail.variantPrice.final_price.formated_price;
          }
        });
      }
    }"
    x-html="price"
  @endif
  {{ $attributes->merge(['class' => 'text-lg font-semibold text-primary']) }}
>
  {!! $product->getTypeInstance()->getPriceHtml() !!}
</div>
