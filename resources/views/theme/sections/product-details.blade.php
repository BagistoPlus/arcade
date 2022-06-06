<div class="py-10">
  <div class="container">
    <div class="md:flex">
      <div class="flex-1">
        <x-product-gallery :product="$product" class="sticky top-4" />
      </div>
      <div class="flex-1 mt-6 md:px-4 md:mt-0">
        <form method="post" wire:submit.prevent>
          @csrf

          @foreach($section->blocks as $block)
            @if($block->type === 'title')

              <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

            @elseif($block->type === 'price')

              <div class="mt-2 flex justify-between">
                <x-product-price :product="$product" />
              </div>

            @elseif($block->type === 'stock')

              <div class="mt-2">
                <x-product-stock-status :product="$product" />
              </div>

            @elseif($block->type === 'short_description')

              <div class="mt-2">
                {!! view_render_event('bagisto.shop.products.view.short_description.before', ['product' => $product]) !!}

                  <div class="prose line-clamp-3">
                    {!! arcade_clear_inline_styles($product->short_description) !!}
                  </div>

                  {!! view_render_event('bagisto.shop.products.view.short_description.after', ['product' => $product]) !!}
              </div>

            @elseif($block->type === 'buy_buttons')

              <div class="mt-4">
                <x-product-buy-buttons
                  :product="$product"
                  :showBuyNowButton="$block->settings->show_buy_now"
                />
              </div>

            @elseif($block->type === 'quantity_selector' && $product->getTypeInstance()->showQuantityBox())

              {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

              <div class="mt-2">
                <x-arcade::quantity-selector
                  :value="$quantity"
                  :label="__('shop::app.products.quantity')"
                  class="mb-4"
                  wire:on-input="$set('quantity', $event.detail, true)"
                />
              </div>

              {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}

            @elseif($block->type === 'description')

              <div class="mt-2">
                {!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

                <x-arcade::accordion class="mt-4" defaultOpen="0">
                  <x-arcade::accordion.item :title="__('shop::app.products.description')">
                    <div class="p-4 prose">
                      {!! arcade_clear_inline_styles($product->description) !!}
                    </div>
                  </x-arcade::accordion.item>
                </x-arcade::accordion>

                {!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!}
              </div>

            @elseif($block->type === 'attributes')

              <div class="mt-2">
                <x-product-attributes :product="$product" />
              </div>

            @elseif($block->type === 'variant_picker' && $this->productHasVariants())

              {!! view_render_event('bagisto.shop.products.view.configurable-options.before', ['product' => $product]) !!}

              <x-product-variant-picker :product="$product" :livewire="$this" />

              {!! view_render_event('bagisto.shop.products.view.configurable-options.after', ['product' => $product]) !!}

            @elseif($block->type === 'downloadable_options' && $product->type === 'downloadable')

              {!! view_render_event('bagisto.shop.products.view.downloadable.before', ['product' => $product]) !!}

              <div class="mt-2">
                <x-product-downloadable-options :product="$product" />
              </div>

              {!! view_render_event('bagisto.shop.products.view.downloadable.after', ['product' => $product]) !!}

            @elseif($block->type === 'grouped_options' && $product->type === 'grouped')

              {!! view_render_event('bagisto.shop.products.view.grouped_products.before', ['product' => $product]) !!}

              <div class="mt-2">
                <x-product-grouped-options :product="$product" />
              </div>

              {!! view_render_event('bagisto.shop.products.view.grouped_products.after', ['product' => $product]) !!}

            @elseif($block->type === 'bundle_options' && $product->type === 'bundle')

              {!! view_render_event('bagisto.shop.products.view.bundle-options.before', ['product' => $product]) !!}

              <div class="mt-2">
                <x-product-bundle-options :product="$product" :livewire="$this" />
              </div>

              {!! view_render_event('bagisto.shop.products.view.bundle-options.after', ['product' => $product]) !!}

            @endif
          @endforeach

        </form>
      </div>
    </div>
  </div>
</div>
