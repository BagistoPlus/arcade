<div x-data="{ open: false }" @click.away="open = false" {{ $attributes }}>
  @if(isset($trigger))
  <div @click="open = ! open">
    {{ $trigger }}
  </div>
  @endif

  <div x-show="open">
    {{ $slot }}
  </div>
</div>
