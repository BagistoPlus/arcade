<x-arcade::popover {{ $attributes->merge(['class' => 'relative']) }}>
  <x-slot name="trigger">
    <button class="p-2 text-center leading-3 text-on-surface hover:text-on-surface-variant">
      <x-heroicon-o-user class="w-6 h-6 inline" />
      <div class="hidden lg:block text-xs font-medium">Profile</div>
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
    class="absolute bg-surface text-on-surface shadow p-4 rounded mt-0 right-0">
    Content
  </div>
</x-arcade::popover>
