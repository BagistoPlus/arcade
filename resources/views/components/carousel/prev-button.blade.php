<div {{ $attributes->merge(['class' => '']) }}>
  @empty($slot->toHtml())
    <button
      class="group w-10 h-10 rounded-full flex items-center justify-center bg-black bg-opacity-5 hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
      x-on:click="previousSlide">
      <x-heroicon-o-chevron-left class="w-6 h-6 text-white" />
    </button>
  @else
    {{ $slot }}
  @endisset
</div>
