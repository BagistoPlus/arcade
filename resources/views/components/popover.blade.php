<div
  x-data="{ open: @if($attributes->has('wire:open')) @entangle($attributes->wire('open')) @else false @endif }"
  @click.away="open = false"
  {{ $attributes }}>
  @if(isset($trigger))
  <div @click="open = ! open">
    {{ $trigger }}
  </div>
  @endif

  <div x-show="open">
    {{ $slot }}
  </div>
</div>
