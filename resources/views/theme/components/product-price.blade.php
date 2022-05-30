@props([
  'product' => null
])

<div
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
  class="text-lg font-semibold text-primary"
  x-html="price"
>
  {!! $product->getTypeInstance()->getPriceHtml() !!}
</div>
