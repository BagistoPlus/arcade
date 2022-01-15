@props([
  'fromLabel' => 'from',
  'toLabel' => 'to'
])

<div
  x-data='ArcadeRangeInput(@json($attributes->except(['class'])->getIterator()->getArrayCopy()))'
  @if($attributes->has('wire:model'))
    x-on:update="$wire.set('{{ $attributes->get('wire:model') }}', $event.detail)"
  @endif
></div>
