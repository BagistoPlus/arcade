<x-arcade::popover {{ $attributes->merge(['class' => 'relative']) }}>
  <x-slot name="trigger">
    <button class="relative text-center leading-3">
      <x-heroicon-o-shopping-bag class="w-5 h-5 inline" />
      <span class="absolute lg:hidden flex -top-1 -right-1 px-1 rounded-full bg-red-500 text-white text-xs font-medium">
        {{ $count }}
      </span>
      <span class="sr-only">items in cart, view bag</span>
      <span class="hidden lg:inline text-sm font-medium">
        Cart ({{ $count }})
      </span>
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
    class="absolute bg-white border p-4 mt-0 right-0">
    Content
    <button wire:click="increment">increment</button>
  </div>
</x-arcade::popover>
