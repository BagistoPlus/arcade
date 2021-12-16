@php
  $heightMap = [
    'screen' => '100vh',
    'small' => '400px',
    'medium' => '500px',
    'large' => '600px'
  ];
  $widthClass = 'w-full';

  if (($section->settings->slide_width ?? 'content') === 'content') {
    $widthClass = 'container mx-auto';
  }

  $slides = collect($section->blocks)->filter(function ($block) {
    return $block->type === 'slide';
  });
@endphp

<x-arcade::carousel
  :controls="$section->settings->show_controls"
  type="carousel"
  :gap="0"
  :autoplay="$section->settings->enable_autoplay ? $section->settings->autoplay_delay * 1000 : false"
  :animationDuration="1000"
  :rewind="false"
  :itemsCount="$slides->count()"
  class="">
  {{-- <x-arcade::carousel.slide class="bg-gray-100 h-96">
    Slide 1
  </x-arcade::carousel.slide>
  <x-arcade::carousel.slide class="bg-blue-100 h-96">
    Slide 2
  </x-arcade::carousel.slide>
  <x-arcade::carousel.slide class="bg-green-100 h-96">
    Slide 3
  </x-arcade::carousel.slide> --}}
  @foreach($slides as $slide)
    <x-arcade::carousel.slide
      class="bg-cover bg-center"
      style="
        height: {{ $heightMap[$section->settings->slide_height] }};
        background-image: url('{{ arcade_image($slide->settings->image) }}');
      ">
    </x-arcade::carousel.slide>
  @endforeach
</x-arcade::carousel>
