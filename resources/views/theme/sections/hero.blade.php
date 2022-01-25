@php
  $heightMap = [
    'small' => '300px',
    'medium' => '400px',
    'large' => '500px'
  ];

  $contentPositionMap = [
    'top' => 'items-start',
    'middle' => 'items-center',
    'bottom' => 'items-end'
  ];

  $buttonStyles = [
    'primary' => 'bg-primary text-white',
    'secondary' => 'border bg-gray-100 text-gray-700 hover:shadow-lg hover:bg-gray-200',
  ];
@endphp

<div class="relative" style="height: {{ $heightMap[$section->settings->height] }}">
  <div class="absolute inset-0 w-full h-full flex">
    @if($section->settings->image)
      <div class="flex-1 bg-cover bg-center bg-no-repeat" style="background-image: url({{ arcade_image($section->settings->image) }})"></div>
    @endif
  </div>

  @if($section->settings->show_overlay)
    <div class="absolute inset-0 w-full h-full bg-black" style="opacity: {{ $section->settings->overlay_opacity }}%"></div>
  @endif

  <div class="z-5 relative h-full py-6 flex justify-center {{ $contentPositionMap[$section->settings->content_position] }}">
    <div class="relative max-w-xl px-8 py-8 text-white">

      @foreach($section->blocks as $block)
        @if($block->type === 'heading')
          <h1 class="text-4xl font-bold leading-tight text-center">
            {{ $block->settings->heading }}
          </h1>
        @elseif($block->type === 'text')
          <p class="mt-4 text-center">
            {{ $block->settings->text }}
          </p>
        @elseif($block->type === 'button')
          <div class="text-center space-x-4 mt-6">
            <a
              href="{{ $block->settings->link }}"
              class="inline-block px-6 py-3 hover:shadow {{ $buttonStyles[$block->settings->style] }}"
            >
              {{ $block->settings->text }}
            </a>
          </div>
        @endif
      @endforeach
    </div>
  </div>
</div>
