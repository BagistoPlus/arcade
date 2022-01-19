@props([
  'label' => '',
  'value' => 1
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
    <label class="block mb-2 font-semibold">{{ $label }}</label>
  @endif

  <div class="flex">
    <button type="button" class="border p-3" x-on:click="quantity > 1 && quantity--">
      <x-heroicon-s-minus class="w-4 h-4" />
    </button>

    <input x-model="quantity" class="border w-16 text-center">

    <button type="button" class="border p-3" x-on:click="quantity++">
      <x-heroicon-o-plus class="w-4 h-4" />
    </button>
  </div>
</div>
