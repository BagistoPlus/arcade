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

  $contentBgStyles = [
    'primary' => 'bg-surface text-on-surface',
    'secondary' => 'bg-surface-variant text-on-surface-variant',
    'primary-invert' => 'bg-on-surface text-surface',
    'secondary-invert' => 'bg-on-surface-variant text-surface-variant'
  ];

  $buttonStyles = [
    'primary' => 'bg-primary text-on-primary',
    'secondary' => 'bg-secondary text-on-secondary',
    'accent' => 'bg-accent text-on-accent',
  ];

  $buttonShown = false;
@endphp

<div class="relative" style="height: {{ $heightMap[$section->settings->height] }}">
  <div class="absolute inset-0 w-full h-full flex">
    @if($section->settings->image1)
      <div class="flex-1" class="bg-cover bg-center" style="background-image: url({{ arcade_image($section->settings->image1) }})"></div>
    @endif
    @if($section->settings->image2)
      <div class="flex-1" class="bg-cover bg-center" style="background-image: url({{ arcade_image($section->settings->image2) }})"></div>
    @endif
  </div>

  @if($section->settings->show_overlay)
    <div class="absolute inset-0 w-full h-full bg-black" style="opacity: {{ $section->settings->overlay_opacity }}%"></div>
  @endif

  <div class="z-5 relative h-full py-6 flex justify-center {{ $contentPositionMap[$section->settings->content_position] }}">
    <div class="
      relative max-w-xl px-8 py-8
      @if($section->settings->show_content_bg)
        {{ $contentBgStyles[$section->settings->content_bg_style] }}
      @else
        text-white
      @endif">

      @foreach($section->blocks as $block)
        @if($block->type === 'heading')
          <h1 class="text-4xl font-bold leading-tight text-center">
            {{ $block->settings->heading }}
          </h1>
        @elseif($block->type === 'text')
          <p class="mt-4 text-center">
            {{ $block->settings->text }}
          </p>
        @elseif($block->type === 'button' && !$buttonShown)
          @php
            $buttonShown = true;
            $buttonBlocks = collect($section->blocks)->filter(function($block) {
              return $block->type === 'button';
            });
          @endphp

          <div class="text-center space-x-4 mt-6">
            @foreach($buttonBlocks as $button)
              <a
                href="{{ $button->settings->link }}"
                class="inline-block px-4 py-3 hover:shadow {{ $buttonStyles[$button->settings->style] }}"
              >
                {{ $button->settings->text }}
              </a>
            @endforeach
          </div>
        @endif
      @endforeach
    </div>
  </div>
</div>
