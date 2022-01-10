<div class="py-10">
  <div class="container">
    <div class="md:flex">
      <div class="flex-1">
        <x-product-gallery :product="$product" class="sticky top-4" />
      </div>
      <div class="flex-1 px-4">
        <form method="post" wire:submit.prevent>
          @csrf

          @foreach($section->blocksOfType(['title', 'price', 'stock', 'short_description', 'buy_buttons']) as $block)
            @if($block->type === 'title')
              <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
            @elseif($block->type === 'price')
              <div class="mt-2 flex justify-between">
                <div class="text-lg font-semibold text-primary">
                  {!! $product->getTypeInstance()->getPriceHtml() !!}
                </div>
              </div>
            @elseif($block->type === 'stock')
              <div class="mt-2">
                <x-product-stock-status :product="$product" />
              </div>
            @elseif($block->type === 'short_description')
              <div class="mt-2">
                {!! view_render_event('bagisto.shop.products.view.short_description.before', ['product' => $product]) !!}

                  <div class="prose">
                    {!! arcade_clear_inline_styles($product->short_description) !!}
                  </div>

                  {!! view_render_event('bagisto.shop.products.view.short_description.after', ['product' => $product]) !!}
              </div>
            @elseif($block->type === 'buy_buttons')
              <div class="mt-2">
                <x-product-buy-buttons
                  :product="$product"
                  :showBuyNowButton="$block->settings->show_buy_now"
                />
              </div>
            @endif
          @endforeach

        </form>
      </div>
    </div>
  </div>
</div>
