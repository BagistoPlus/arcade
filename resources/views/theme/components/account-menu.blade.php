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
    x-transition:enter="transition ease-out duration-100 origin-top"
    x-transition:leave="transition ease-in duration-100 origin-top"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="absolute bg-white text-on-surface border p-4 mt-2 right-0">

    @guest('customer')
      <div class="w-72">
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
    @endguest
  </div>
</x-arcade::popover>
