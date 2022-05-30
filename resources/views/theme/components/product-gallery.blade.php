<div
  x-data="ArcadeProductGallery({ images: @js($images) })"
  {{ $attributes->merge(['class' => 'md:flex'])}}
>
  <div class="md:flex-1 md:order-1 border">
    <template x-for="(image, index) in images" x-bind:key="index">
      <div x-show="activeImage === index" class="relative w-full aspect-w-1 aspect-h-1 border overflow-hidden">
        <img x-bind:src="image.large_image_url" alt="{{ $product->name }} image" class="absolute w-full h-full object-cover">
      </div>
    </template>
  </div>

  <div class="md:flex-none md:w-20 md:order-0 flex md:block space-x-4 md:space-x-0 md:space-y-4 mt-4 md:mt-0">
    <template x-for="(image, index) in images" x-bind:key="index">
      <a
        class="flex-none block w-16 border overflow-hidden cursor-pointer"
        x-bind:class="{ 'border-2 border-primary p-px': activeImage === index }"
        x-on:click.prevent="activeImage = index"
      >
        <div class="relative w-full aspect-w-1 aspect-h-1 overflow-hidden">
          <img alt="{{ $product->name }} image" x-bind:src="image.small_image_url" class="absolute object-cover w-full h-full">
        </div>
      </a>
    </template>
  </div>
</div>
