@php
  $positionValues = [
    'left' => 'justify-start',
    'center' => 'justify-center',
    'right' => 'justify-end'
  ];

  $styles = [
    'primary' => 'bg-primary text-on-primary dark:bg-primary-dark dark:text-on-primary-dark',
    'secondary' => 'bg-secondary text-on-secondary dark:bg-secondary-dark dark:text-on-secondary-dark',
    'accent' => 'bg-accent text-on-accent dark:bg-accent-dark dark:text-on-accent-dark',
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
