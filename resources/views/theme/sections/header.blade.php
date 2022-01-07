<div x-data="{ searchFormOpen: window.innerWidth >= 992, mobileMenuOpen: false }">
  <header>
    <nav class="relative border-b">
      <div class="lg:container flex items-center">
        <button class="flex-none p-4 lg:hidden" x-on:click="mobileMenuOpen = true">
          <x-heroicon-o-menu class="w-5 h-5" />
        </button>

        <div class="flex-none py-4 pr-4">
          <a href="{{ route('shop.home.index') }}" aria-label="Logo">
            @if ($logo = core()->getCurrentChannel()->logo_url)
              <span class="sr-only">{{ config('app.name') }}</span>
              <img class="h-8" src="{{ $logo }}" alt="" />
            @else
              {{ config('app.name') }}
            @endif
          </a>
        </div>

        <form x-show="searchFormOpen" class="flex absolute inset-0 w-full h-full bg-white z-20 lg:static lg:w-auto lg:h-auto">
          <button type="button" class="p-4 flex-none lg:hidden" x-on:click="searchFormOpen = false">
            <x-heroicon-o-arrow-left class="w-5 h-5" />
          </button>

          <input
            class="flex-1 focus:outline-none lg:px-4 lg:ml-10 lg:w-96 lg:border"
            x-ref="mobileSearchInput"
            placeholder="Search our store"
          >

          <button class="p-4 lg:p-2 flex-none text-primary lg:text-gray-500 lg:border lg:border-l-0">
            <x-heroicon-o-search class="w-5 h-5" />
          </button>
        </form>

        <div class="flex-1 flex justify-end">
          <button
            class="flex-none py-4 pr-4 lg:hidden"
            x-on:click="
              searchFormOpen = true;
              $nextTick(() => $refs.mobileSearchInput.focus())
            ">
            <x-heroicon-o-search class="w-5 h-5" />
          </button>

          @arcade_slot('bagisto.shop.layout.header.account-item.before')
          <x-account-menu class="z-10 py-4 pr-4 lg:pl-4" />
          @arcade_slot('bagisto.shop.layout.header.account-item.after')

          @arcade_slot('bagisto.shop.layout.header.cart-item.before')
          <livewire:mini-cart class="z-10 py-4 pr-4 lg:pl-4" />
          @arcade_slot('bagisto.shop.layout.header.cart-item.after')
        </div>
      </div>
      <div class="hidden lg:block bg-gray-100 border-t">
        <div class="container flex space-x-1">
          @foreach($categories as $category)
            <a href="{{ url()->to($category->translations[0]->url_path) }}" class="flex items-center px-4 py-3 font-medium border-b-2 border-transparent hover:border-black">
              {{ $category->name }}
            </a>
          @endforeach
        </div>
      </div>
    </nav>

    <div
      class="fixed inset-0 flex z-40"
      role="dialog"
      aria-modal="true"
      x-show="mobileMenuOpen"
      x-cloak>

      <div
        x-show="mobileMenuOpen"
        class="fixed inset-0 bg-black bg-opacity-25"
        x-bind:aria-hidden="mobileMenuOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="mobileMenuOpen = false"
      ></div>

      <div
        x-show="mobileMenuOpen"
        class="relative max-w-xs w-full bg-white border-r pb-12 flex flex-col overflow-y-auto"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full">
      </div>
    </div>
  </header>
</div>
