@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
  $categories = [];

  foreach ($categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id) as $category) {
    if ($category->slug) {
      array_push($categories, $category);
    }
  }
@endphp

<div x-data="{ mobileMenuOpen: false }">
  <!--
    Mobile menu

    Off-canvas menu for mobile, show/hide based on off-canvas menu state.
  -->
  <div
    class="fixed inset-0 flex z-40 lg:hidden"
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
      class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto"
      x-transition:enter="transition ease-in-out duration-300 transform"
      x-transition:enter-start="-translate-x-full"
      x-transition:enter-end="translate-x-0"
      x-transition:leave="transition ease-in-out duration-300 transform"
      x-transition:leave-start="translate-x-0"
      x-transition:leave-end="-translate-x-full">
      <div class="px-4 pt-5 pb-2 flex">
        <button type="button" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400" x-on:click="mobileMenuOpen = false">
          <span class="sr-only">Close menu</span>
          <!-- Heroicon name: outline/x -->
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Links -->
      <div class="mt-2">
        <div class="border-b border-gray-200">
          <div class="-mb-px flex px-4 space-x-8" aria-orientation="horizontal" role="tablist">
            <!-- Selected: "text-indigo-600 border-indigo-600", Not Selected: "text-gray-900 border-transparent" -->
            <button id="tabs-1-tab-1" class="text-gray-900 border-transparent flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium" aria-controls="tabs-1-panel-1" role="tab" type="button">
              Women
            </button>

            <!-- Selected: "text-indigo-600 border-indigo-600", Not Selected: "text-gray-900 border-transparent" -->
            <button id="tabs-1-tab-2" class="text-gray-900 border-transparent flex-1 whitespace-nowrap py-4 px-1 border-b-2 text-base font-medium" aria-controls="tabs-1-panel-2" role="tab" type="button">
              Men
            </button>
          </div>
        </div>

        <!-- 'Women' tab panel, show/hide based on tab state. -->
        <div id="tabs-1-panel-1" class="pt-10 pb-8 px-4 space-y-10" aria-labelledby="tabs-1-tab-1" role="tabpanel" tabindex="0">
          <div class="grid grid-cols-2 gap-x-4">
            <div class="group relative text-sm">
              <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden group-hover:opacity-75">
                <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg" alt="Models sitting back to back, wearing Basic Tee in black and bone." class="object-center object-cover">
              </div>
              <a href="#" class="mt-6 block font-medium text-gray-900">
                <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                New Arrivals
              </a>
              <p aria-hidden="true" class="mt-1">Shop now</p>
            </div>

            <div class="group relative text-sm">
              <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden group-hover:opacity-75">
                <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg" alt="Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees." class="object-center object-cover">
              </div>
              <a href="#" class="mt-6 block font-medium text-gray-900">
                <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                Basic Tees
              </a>
              <p aria-hidden="true" class="mt-1">Shop now</p>
            </div>
          </div>

          <div>
            <p id="women-clothing-heading-mobile" class="font-medium text-gray-900">
              Clothing
            </p>
            <ul role="list" aria-labelledby="women-clothing-heading-mobile" class="mt-6 flex flex-col space-y-6">
              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Tops
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Dresses
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Pants
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Denim
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Sweaters
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  T-Shirts
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Jackets
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Activewear
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Browse All
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- 'Men' tab panel, show/hide based on tab state. -->
        <div id="tabs-1-panel-2" class="pt-10 pb-8 px-4 space-y-10" aria-labelledby="tabs-1-tab-2" role="tabpanel" tabindex="0">
          <div class="grid grid-cols-2 gap-x-4">
            <div class="group relative text-sm">
              <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden group-hover:opacity-75">
                <img src="https://tailwindui.com/img/ecommerce-images/product-page-04-detail-product-shot-01.jpg" alt="Drawstring top with elastic loop closure and textured interior padding." class="object-center object-cover">
              </div>
              <a href="#" class="mt-6 block font-medium text-gray-900">
                <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                New Arrivals
              </a>
              <p aria-hidden="true" class="mt-1">Shop now</p>
            </div>

            <div class="group relative text-sm">
              <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden group-hover:opacity-75">
                <img src="https://tailwindui.com/img/ecommerce-images/category-page-02-image-card-06.jpg" alt="Three shirts in gray, white, and blue arranged on table with same line drawing of hands and shapes overlapping on front of shirt." class="object-center object-cover">
              </div>
              <a href="#" class="mt-6 block font-medium text-gray-900">
                <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                Artwork Tees
              </a>
              <p aria-hidden="true" class="mt-1">Shop now</p>
            </div>
          </div>

          <div>
            <p id="men-clothing-heading-mobile" class="font-medium text-gray-900">
              Clothing
            </p>
            <ul role="list" aria-labelledby="men-clothing-heading-mobile" class="mt-6 flex flex-col space-y-6">
              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Tops
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Pants
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Sweaters
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  T-Shirts
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Jackets
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Activewear
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Browse All
                </a>
              </li>
            </ul>
          </div>

          <div>
            <p id="men-accessories-heading-mobile" class="font-medium text-gray-900">
              Accessories
            </p>
            <ul role="list" aria-labelledby="men-accessories-heading-mobile" class="mt-6 flex flex-col space-y-6">
              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Watches
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Wallets
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Bags
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Sunglasses
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Hats
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Belts
                </a>
              </li>
            </ul>
          </div>

          <div>
            <p id="men-brands-heading-mobile" class="font-medium text-gray-900">
              Brands
            </p>
            <ul role="list" aria-labelledby="men-brands-heading-mobile" class="mt-6 flex flex-col space-y-6">
              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Re-Arranged
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Counterfeit
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  Full Nelson
                </a>
              </li>

              <li class="flow-root">
                <a href="#" class="-m-2 p-2 block text-gray-500">
                  My Way
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-200 py-6 px-4 space-y-6">
        <div class="flow-root">
          <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Company</a>
        </div>

        <div class="flow-root">
          <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Stores</a>
        </div>
      </div>

      <div class="border-t border-gray-200 py-6 px-4 space-y-6">
        <div class="flow-root">
          <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Sign in</a>
        </div>
        <div class="flow-root">
          <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Create account</a>
        </div>
      </div>

      <div class="border-t border-gray-200 py-6 px-4">
        <a href="#" class="-m-2 p-2 flex items-center">
          <img src="https://tailwindui.com/img/flags/flag-canada.svg" alt="" class="w-5 h-auto block flex-shrink-0">
          <span class="ml-3 block text-base font-medium text-gray-900">
            CAD
          </span>
          <span class="sr-only">, change currency</span>
        </a>
      </div>
    </div>
  </div>

  <header class="relative bg-surface shadow">
    <nav aria-label="Top" class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="h-16 flex items-center">
        <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
        <button type="button" class="bg-white p-2 rounded-md lg:hidden" x-on:click="mobileMenuOpen = true">
          <span class="sr-only">Open menu</span>
          <x-heroicon-o-menu class="h-6 w-6" />
        </button>

        <!-- Logo -->
        <div>
          <a href="{{ route('shop.home.index') }}" aria-label="Logo">
            @if ($logo = core()->getCurrentChannel()->logo_url)
              <span class="sr-only">{{ config('app.name') }}</span>
              <img class="max-h-10" src="{{ $logo }}" alt="" />
            @else
              {{ config('app.name') }}
            @endif
          </a>
        </div>

        <div class="hidden flex-1 h-full space-x-4 lg:flex lg:ml-6">
          @foreach($categories as $category)
          <a href="{{ url()->to($category->translations[0]->url_path) }}" class="flex items-center px-4 text-on-surface font-medium hover:font-semibold border-b-2 border-transparent hover:border-primary">
            {{ $category->name }}
          </a>
          @endforeach
        </div>

        <!-- Search bar -->
        <div class="flex lg:hidden">
          <a href="#" class="p-2 text-gray-400 hover:text-gray-500">
            <span class="sr-only">Search</span>
            <!-- Heroicon name: outline/search -->
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </a>
        </div>

        <div class="ml-auto flex items-center space-x-2 md:space-x-4">
          @arcade_slot('bagisto.shop.layout.header.currency-item.before')
          <x-currency-switcher class="hidden z-10 lg:block" />
          @arcade_slot('bagisto.shop.layout.header.currency-item.after')

          @arcade_slot('bagisto.shop.layout.header.account-item.before')
          <x-account-menu class="z-10" />
          @arcade_slot('bagisto.shop.layout.header.account-item.after')

          @arcade_slot('bagisto.shop.layout.header.cart-item.before')
          <livewire:mini-cart class="z-10" />
          @arcade_slot('bagisto.shop.layout.header.cart-item.after')
        </div>
      </div>
    </nav>
  </header>
</div>
