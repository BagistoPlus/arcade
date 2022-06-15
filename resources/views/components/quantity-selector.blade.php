@props([
  'label' => '',
  'value' => 1,
  'id' => 'quantity-selector',
])

<div
  x-data="{
    quantity: {{ $value }},
    init() {
      this.$watch('quantity', (value) => {
        this.$dispatch('on-input', value);
      })
    }
  }"
  {{ $attributes }}
>
  @if($label)
    <label for="{{ $id }}" class="block mb-1 font-medium">{{ $label }}</label>
  @else
    <label for="{{ $id }}" class="sr-only	">{{ __('Quantity') }}</label>
  @endif

  <div class="flex">
    <button type="button" aria-label="decrement" class="border p-3" x-on:click="quantity > 1 && quantity--">
      <x-heroicon-s-minus class="w-4 h-4" />
    </button>

    <input id="{{ $id }}" x-model="quantity" class="border w-16 text-center">

    <button type="button" aria-label="increment" class="border p-3" x-on:click="quantity++">
      <x-heroicon-o-plus class="w-4 h-4" />
    </button>
  </div>
</div>
