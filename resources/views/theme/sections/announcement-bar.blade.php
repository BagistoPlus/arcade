@php
  $positionValues = [
    'left' => 'justify-start',
    'center' => 'justify-center',
    'right' => 'justify-end'
  ];

  $styles = [
    'primary' => 'bg-primary text-on-primary',
    'secondary' => 'bg-secondary text-on-secondary',
    'accent' => 'bg-accent text-on-accent',
  ]
@endphp

@if (true)
  <div class="
    flex py-1 px-4
    {{ $styles[$section->settings->style] }}
    {{ $positionValues[$section->settings->position] }}">
    {{ $section->settings->announcement }}
  </div>
@endif
