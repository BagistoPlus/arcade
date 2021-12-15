<div
  x-data="ArcadeDropdown"
  x-on:click.away="close"
  x-on:keydown.escape.window="close"
  {{ $attributes->merge(['class' => 'relative']) }}>
  {{ $slot }}
</div>
