{!! view_render_event('bagisto.shop.products.view.product-add.before', ['product' => $product]) !!}

<div class="md:flex md:space-x-4 space-y-3 md:space-y-0">
  <button
    type="button"
    wire:click="addToCart"
    class="relative block w-full md:flex-1 lg:w-1/2 py-3 {{ $product->isSaleable() ? 'bg-black text-white' : 'bg-gray-200 cursor-not-allowed' }}"
    wire:loading.class="text-transparent relative pointer-events-none"
    wire:target="addToCart"
    {{ $product->isSaleable() ? '' : 'disabled' }}>
    {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}

    <div wire:loading wire:target="addToCart" class="text-white absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
      <div class="w-4 h-4 rounded-full border-2 border-current border-r-transparent animate animate-spin"></div>
    </div>
  </button>

  @if($showBuyNowButton)
    <button
      type="button"
      wire:click="buyNow"
      class="relative block w-full md:flex-1 lg:w-1/2 py-3 {{ $product->isSaleable() ? 'bg-primary text-white' : 'bg-gray-200 cursor-not-allowed' }}"
      wire:loading.class="text-transparent relative pointer-events-none"
      wire:target="buyNow"
      {{ $product->isSaleable() ? '' : 'disabled' }}>
      {{ __('shop::app.products.buy-now') }}

      <div wire:loading wire:target="buyNow" class="text-white absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
        <div class="w-4 h-4 rounded-full border-2 border-current border-r-transparent animate animate-spin"></div>
      </div>
    </button>
  @endif
</div>

{!! view_render_event('bagisto.shop.products.view.product-add.after', ['product' => $product]) !!}
