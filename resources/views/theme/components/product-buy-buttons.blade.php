{!! view_render_event('bagisto.shop.products.view.product-add.before', ['product' => $product]) !!}

<div class="md:flex space-x-4">
  <button
    type="button"
    wire:click="addToCart"
    class="relative md:flex-1 lg:w-1/2 py-3 bg-black text-white"
    wire:loading.class="text-transparent relative pointer-events-none"
    wire:target="addToCart">
    {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}

    <div wire:loading wire:target="addToCart" class="text-white absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
      <div class="w-4 h-4 rounded-full border-2 border-current border-r-transparent animate animate-spin"></div>
    </div>
  </button>
</div>

{!! view_render_event('bagisto.shop.products.view.product-add.after', ['product' => $product]) !!}
