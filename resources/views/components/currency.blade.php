@props([
  'amount' => 0,
])

<span {{ $attributes }}>{{ core()->currency($amount) }}</span>
