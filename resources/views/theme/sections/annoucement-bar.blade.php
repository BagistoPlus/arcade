@push('css')

@endpush

@php
  $positionValues = [
    'left' => 'justify-start',
    'center' => 'justify-center',
    'right' => 'justify-end'
  ];
@endphp

Annoucement bar
{{-- @if ($section->settings->show_announcement)
<div class="
  flex py-1 px-4
  bg-{{ $section->settings->bg_color }}-500
  text-{{ $section->settings->text_color }}
  {{ $positionValues[$section->settings->position] }}
">
  {{ $section->settings->annoucement }}
</div>
@endif --}}
