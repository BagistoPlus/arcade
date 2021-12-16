@props([
  'controls' => true,
  'navigation' => true,
  'itemsCount' => 0
])

@php
  $options = $attributes
    ->except(['class'])
    ->merge([
    ])
    ->getIterator()
    ->getArrayCopy()
@endphp

<div x-data='ArcadeCarousel(@json($options))'>
  <div class="glide relative">
    <div class="glide__track" data-glide-el="track">
      <div class="glide__slides">
        {{ $slot }}
      </div>
    </div>

    @if($controls)
      @isset($carouselControls)
        {{ $carouselControls }}
      @else
        <x-arcade::carousel.prev-button class="absolute left-2 top-1/2 transform -translate-y-1/2" />
        <x-arcade::carousel.next-button class="absolute right-2 top-1/2 transform -translate-y-1/2" />
      @endif
    @endif

    @if($navigation)
      @isset($carouselNavigation)
        {{ $carouselNavigation }}
      @else
        <div class="absolute flex justify-center w-full space-x-4 bottom-4">
          @for ($i = 0; $i < $itemsCount; $i++)
            <button class="flex items-center justify-center w-3 h-3 bg-white rounded-full cursor-pointer" x-on:click="goto({{ $i }})">
              <div x-show="activeIndex === {{ $i }}" class="w-[6px] h-[6px] bg-black bg-opacity-30 rounded-full"></div>
            </button>
          @endfor
        </div>
      @endisset
    @endif
  </div>
</div>
