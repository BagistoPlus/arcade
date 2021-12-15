@if($hasMultipleCurrencies())
<x-arcade::dropdown {{ $attributes }}>
  <x-arcade::dropdown.button class="text-on-surface hover:text-on-surface-variant">
    <div class="flex items-center">
      {{ $currentCurrency->code }}
      <x-heroicon-s-chevron-down
        class="w-4 h-4"
        x-bind:class="{'transform rotate-180': opened }"
      />
    </div>
    <div class="hidden lg:block text-xs">Currency</div>
  </x-arcade::dropdown.button>

  <x-arcade::dropdown.content class="mt-2 -right-2 w-36 py-1 rounded shadow bg-surface text-on-surface">
    @foreach($currencies as $currency)
      <x-arcade::dropdown.item>
        <a
          class="block px-3 py-2 cursor-pointer text-sm hover:bg-surface-variant hover:text-on-surface-variant"
          href="{{ $switchCurrencyUrl($currency->code) }}">
          {{ $currency->name }} ({{ $currency->code }})
        </a>
      </x-arcade::dropdown.item>
    @endforeach
  </x-arcade::dropdown.content>
</x-arcade::dropdown>
@endif
