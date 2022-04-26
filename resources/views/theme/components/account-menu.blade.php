<x-arcade::popover {{ $attributes->merge(['class' => 'relative']) }}>
  <x-slot name="trigger">
    <button class="text-center leading-3">
      <x-heroicon-o-user class="w-5 h-5 inline" />
      <span class="hidden lg:inline text-sm font-medium">Profile</span>
    </button>
  </x-slot>
  <div
    x-show="open"
    x-cloak
    x-transition.origin.top.right
    class="absolute bg-white text-on-surface border mt-2 right-0">

    @guest('customer')
      <div class="w-72 p-4">
        <h3 class="uppercase text-xl font-semibold">{{ __('shop::app.header.title') }}</h3>
        <p>{{ __('shop::app.header.dropdown-text') }}</p>
        <div class="space-x-4 mt-6 mb-2">
          <a href="{{ route('customer.session.index') }}" class="px-4 py-3 text-base bg-primary text-white">
            {{ __('shop::app.header.sign-in') }}
          </a>

          <a href="{{ route('customer.register.index') }}" class="px-4 py-3 text-base bg-primary text-white">
            {{ __('shop::app.header.sign-up') }}
          </a>
        </div>
      </div>
    @else
      @php
        $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
      @endphp

      <div class="w-56 py-3">
        <h3 class="uppercase text-lg font-semibold px-4">
          {{ auth()->guard('customer')->user()->first_name }}
        </h3>

        <div role="none" class="mt-2">
          <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
          <a
            href="{{ route('customer.profile.index') }}"
            class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900"
            role="menuitem"
            tabindex="-1">
            {{ __('shop::app.header.profile') }}
          </a>

          <a
            href="{{ route('customer.orders.index') }}"
            class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900"
            role="menuitem"
            tabindex="-1">
            {{ __('shop::app.customer.account.order.index.title') }}
          </a>

          @if ($showWishlist)
            <a
              href="{{ route('customer.wishlist.index') }}"
              class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900"
              role="menuitem"
              tabindex="-1">
              {{ __('shop::app.header.wishlist') }}
            </a>
          @endif

          <a
            href="{{ route('customer.session.destroy') }}"
            class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900"
            role="menuitem"
            tabindex="-1">
            {{ __('shop::app.header.logout') }}
          </a>
        </div>
      </div>
    @endguest


  </div>
</x-arcade::popover>
