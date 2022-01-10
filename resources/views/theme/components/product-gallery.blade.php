<div x-data="{ activeImage: 0 }" {{ $attributes->merge(['class' => 'md:flex'])}}>
  <div class="md:flex-1 md:order-1 border">
    @foreach($images as $index => $image)
      <div x-show="activeImage === {{ $index }}" class="relative w-full aspect-w-1 aspect-h-1 overflow-hidden">
        <img src="{{ $image['large_image_url'] }}" class="absolute w-full h-full object-cover">
      </div>
    @endforeach
  </div>

  <div class="md:flex-none md:w-20 md:order-0 flex md:block space-x-4 md:space-x-0 md:space-y-4 mt-4 md:mt-0">
    @foreach($images as $index => $image)
      <a
        class="flex-none block w-16 border overflow-hidden cursor-pointer"
        :class="{ 'border-2 border-primary p-px': activeImage === {{ $index }} }"
        x-on:click="activeImage = {{ $index }}"
      >
        <div class="relative w-full aspect-w-1 aspect-h-1 overflow-hidden">
          <img alt="" src="{{ $image['small_image_url'] }}" class="absolute object-cover w-full h-full">
        </div>
      </a>
    @endforeach
  </div>
</div>
