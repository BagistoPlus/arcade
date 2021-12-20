@php
  $heightMap = [
    'small' => '225px',
    'medium' => '260px',
    'large' => '300px',
  ];

  $itemsSize = [
    0 => [
      1 => 'col-span-7',
      2 => 'col-span-4',
      3 => 'col-span-2',
      4 => 'col-span-2 row-span-2',
      5 => 'col-span-2',
    ],
    1 => [
      2 => 'col-span-3',
      3 => 'col-span-3',
      4 => 'col-span-3 row-span-2',
      5 => 'col-span-2 row-start-2',
    ],
    2 => [
      3 => 'col-span-2',
      4 => 'col-span-2',
      5 => 'col-span-3 row-span-2',
    ],
    3 => [
      4 => 'col-span-2',
      5 => 'col-span-2',
    ],
    4 => [
      5 => 'col-span-2',
    ]
  ];

  $contentPositions = [
    'top-left' => 'justify-start items-start',
    'top-center' => 'justify-center items-start',
    'top-right' => 'justify-end items-start',
    'middle-left' => 'justify-start items-center',
    'middle-center' => 'justify-center items-center',
    'middle-right' => 'justify-end items-center',
    'bottom-left' => 'justify-start items-end',
    'bottom-center' => 'justify-center items-end',
    'bottom-right' => 'justify-end items-end',
  ]
@endphp

<div class="container mx-auto my-16 px-4 sm:px-6 lg:px-8">
  <div class="grid gap-y-6 md:gap-x-6 md:grid-cols-7">

    @foreach($section->blocks as $key => $item)
    <div
      class="{{ $itemsSize[$key][count($section->blocks)] }} group relative rounded overflow-hidden bg-surface-variant"
      style="
        min-height: {{ $heightMap[$section->settings->height] }};
        background-color: {{ $item->settings->bg_color }};
        color: {{ $item->settings->text_color }}
      ">
        @if($item->settings->image)
          <div class="absolute inset-0 w-full h-full bg-cover bg-center scale-105 group-hover:scale-125 transition-all duration-1000" style="background-image: url({{ arcade_image($item->settings->image) }})"></div>
        @endif

        @if($item->settings->show_overlay)
          <div class="absolute inset-0 w-full h-full bg-gradient-to-b from-black to-transparent opacity-20"></div>
        @endif

        <div class="relative p-6 flex h-full w-full {{ $contentPositions[$item->settings->content_position] }}">
          <div>
            <p class="font-bold text-xl">{{ $item->settings->heading }}</p>
            <p class="my-1">{{ $item->settings->text }}</p>
            @if($item->settings->button_text)
              <button
                class="my-2 py-3 px-6 rounded hover:shadow"
                style="
                  background-color: {{ $item->settings->button_bg_color }};
                  color: {{ $item->settings->button_text_color }};
                "
              >
                {{ $item->settings->button_text }}
              </button>
            @endif
          </div>
        </div>

        @if($item->settings->button_link)
          <a href="{{ $item->settings->button_link }}" class="absolute inset-0 w-full h-full bg-surface-variant-transparent-darker"></a>
        @endif
    </div>
    @endforeach

  </div>
</div>
