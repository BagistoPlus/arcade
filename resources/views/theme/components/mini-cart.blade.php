<x-arcade::popover wire:open="expanded" {{ $attributes->merge(['class' => 'relative']) }}>
  <x-slot name="trigger">
    <button class="relative text-center leading-3">
      <x-heroicon-o-shopping-bag class="w-5 h-5 inline" />
      <span class="absolute lg:hidden flex -top-1 -right-1 px-1 rounded-full bg-red-500 text-white text-xs font-medium">
        {{ $this->itemsCount }}
      </span>
      <span class="sr-only">items in cart, view bag</span>
      <span class="hidden lg:inline text-sm font-medium">
        {{ __('shop::app.header.cart') }} ({{ $this->itemsCount }})
      </span>
    </button>
  </x-slot>
  <div
    x-show="open"
    x-cloak
    x-transition.origin.top.right
    class="absolute bg-white border mt-2 mr-2 right-0 w-96">

    @if($this->isCartEmpty)
      <div class="flex flex-col items-center p-4">
        <p class="text-center mt-4">
          Your cart is empty
        </p>
        <a href="{{ route('shop.search.index') }}" class="block w-full text-center font-semibold text-white bg-black py-2 mt-4">
          Browse products
        </a>
      </div>
    @else
      <div class="p-4">
        @foreach($this->cartItems as $item)
          <div class="flex items-center mb-4 pb-4 border-b last:border-b-0 last:mb-0 border-gray-300">
            <div class="relative w-20 flex-none">
              <div class="relative border pb-[100%] overflow-hidden">
                <img alt="{{ $item->name }}" src="{{ $item->smallImage }}" class="absolute object-cover w-full h-full">
              </div>
              <button type="button" class="absolute -top-1 -left-1 bg-black text-white rounded-full" wire:click="removeItemFromCart({{ $item->id }})">
                <x-heroicon-o-x class="w-4 h-4" />
              </button>
            </div>

            <div class="ml-4 flex-1">
              {!! view_render_event('bagisto.shop.checkout.cart-mini.item.name.before', ['item' => $item]) !!}
              <div class="mt-1 line-clamp-2">
                <a href="{{ route('shop.productOrCategory.index', $item->product->url_key) }}">
                  {{ $item->name }}
                </a>
              </div>
              {!! view_render_event('bagisto.shop.checkout.cart-mini.item.name.after', ['item' => $item]) !!}

              {!! view_render_event('bagisto.shop.checkout.cart-mini.item.price.before', ['item' => $item]) !!}
              <div class="flex justify-between">
                <x-arcade::currency :amount="$item->displayablePrice" class="font-bold" />
                <div>
                  Qty: {{ $item->quantity }}
                </div>
              </div>
              {!! view_render_event('bagisto.shop.checkout.cart-mini.item.price.after', ['item' => $item]) !!}

              {!! view_render_event('bagisto.shop.checkout.cart-mini.item.quantity.before', ['item' => $item]) !!}
              {!! view_render_event('bagisto.shop.checkout.cart-mini.item.quantity.after', ['item' => $item]) !!}
            </div>
          </div>
        @endforeach
      </div>

      <hr class="border-t">

      <div class="p-4">
        <div class="flex justify-between">
          <span>
            {{ __('shop::app.checkout.cart.cart-subtotal') }}
          </span>

          {!! view_render_event('bagisto.shop.checkout.cart-mini.subtotal.before', ['cart' => $this->cart]) !!}

          <x-arcade::currency :amount="$this->cartSubTotal" class="font-semibold"/>

          {!! view_render_event('bagisto.shop.checkout.cart-mini.subtotal.after', ['cart' => $this->cart]) !!}
        </div>

        <div class="flex space-x-6 mt-4">
          <a href="{{ route('shop.checkout.cart.index') }}" class="py-2 block w-full text-center font-semibold text-primary">
            {{ __('shop::app.minicart.view-cart') }}
          </a>
          <a href="{{ route('shop.checkout.onepage.index') }}" class="py-2 block w-full text-center font-semibold text-white bg-primary">
            {{ __('shop::app.minicart.checkout') }}
          </a>
        </div>
      </div>
    @endif
  </div>
</x-arcade::popover>
