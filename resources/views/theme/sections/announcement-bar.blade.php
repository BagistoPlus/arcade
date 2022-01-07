@php
  $positionValues = [
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right'
  ];
@endphp

@if ($section->settings->show_announcement)
  <div class="
    py-1 px-4 bg-primary-dark text-white
    {{ $positionValues[$section->settings->position] }}">
    {{ $section->settings->announcement }}
  </div>
@endif
