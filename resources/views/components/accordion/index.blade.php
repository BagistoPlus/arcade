@props([
  'defaultOpen' => -1,
])

<div x-data="{ active: {{ $defaultOpen }} }" {{ $attributes->merge(['class' => 'space-y-4'])}}>
  {{ $slot }}
</div>
