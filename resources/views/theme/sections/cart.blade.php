<div class="py-16">
  <div class="container">
    @if($this->isCartEmpty())
      <h1 class="text-3xl font-medium mb-5 text-center">
        {{ __('shop::app.checkout.cart.title') }}
      </h1>

      <div class="text-center">
        <p>{{ __('shop::app.checkout.cart.empty') }}</p>

        <p class="py-10">
          <a href="{{ route('shop.home.index') }}" class="py-4 px-6 bg-black text-white">
            {{ __('shop::app.checkout.cart.continue-shopping') }}
          </a>
        </p>
    </div>
    @else
      <h1 class="text-3xl font-medium mb-5">
        {{ __('shop::app.checkout.cart.title') }}
      </h1>

      <div class="lg:flex lg:items-start lg:space-x-6 space-y-6 lg:space-y-0">
        <div class="flex-1 space-y-2">
          @foreach($this->cartItems as $item)
            <div class="border p-4 lg:flex lg:flex-wrap lg:items-center">
              <div class="text-center flex-none">
                <img src="{{ $item->smallImage }}" alt="{{ $item->product->name }}" class="inline w-32 h-32">
              </div>

              <div class="lg:flex-1 lg:ml-2">

                {!! view_render_event('bagisto.shop.checkout.cart.item.name.before', ['item' => $item]) !!}

                <h3 class="text-center lg:text-left font-medium">{{ $item->product->name }}</h3>

                {!! view_render_event('bagisto.shop.checkout.cart.item.name.after', ['item' => $item]) !!}

                {!! view_render_event('bagisto.shop.checkout.cart.item.price.before', ['item' => $item]) !!}

                <div class="text-center lg:text-left">
                  <x-arcade::currency :amount="$item->displayablePrice" class="font-bold" />
                </div>

                {!! view_render_event('bagisto.shop.checkout.cart.item.price.after', ['item' => $item]) !!}

                {!! view_render_event('bagisto.shop.checkout.cart.item.options.before', ['item' => $item]) !!}

                @if (isset($item->additional['attributes']))
                  <div class="text-center lg:text-left mt-4 text-sm">
                    @foreach ($item->additional['attributes'] as $attribute)
                      <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                    @endforeach
                  </div>
                @endif

                {!! view_render_event('bagisto.shop.checkout.cart.item.options.after', ['item' => $item]) !!}

              </div>

              {!! view_render_event('bagisto.shop.checkout.cart.item.quantity.before', ['item' => $item]) !!}

              <div class="flex lg:flex-col items-center lg:items-start justify-center mt-4">
                <label class="lg:block lg:pl-2 lg:mb-1">{{ __('shop::app.products.quantity') }}</label>
                <x-arcade::quantity-selector
                  class="ml-2"
                  value="{{ $item->quantity }}"
                  wire:on-input="updateCartItemQuantity({{ $item->id }}, $event.detail)"
                />
                <a
                  class="ml-2 lg:mt-2 text-sm hover:text-primary"
                  href="{{ route('shop.checkout.cart.remove', $item->id) }}"
                  wire:click.prevent="removeItemFromCart({{ $item->id }})"
                >
                  {{ __('shop::app.checkout.cart.remove-link') }}
                </a>
              </div>

              {!! view_render_event('bagisto.shop.checkout.cart.item.quantity.after', ['item' => $item]) !!}
            </div>
          @endforeach
        </div>
        <div class="flex-none lg:w-96 border p-4">
          {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $this->cart]) !!}

          <x-cart-summary />
          <livewire:cart-apply-coupon class="mt-8" />

          {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $this->cart]) !!}
        </div>
      </div>
    @endif
  </div>
</div>
