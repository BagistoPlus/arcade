@props([
  'text' => ''
])

<div role="menuitem" {{ $attributes->merge(['class' => '']) }}>
  {{ $text ?: $slot }}
</div>
