@php
  $positionValues = [
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right'
  ];

  $styles = [
    'primary' => 'bg-primary text-on-primary',
    'secondary' => 'bg-secondary text-on-secondary',
    'accent' => 'bg-accent text-on-accent',
  ]
@endphp

@if ($section->settings->show_announcement)
  <div class="
    py-1 px-4
    {{ $styles[$section->settings->style] }}
    {{ $positionValues[$section->settings->position] }}">
    {{ $section->settings->announcement }}
  </div>
@endif
