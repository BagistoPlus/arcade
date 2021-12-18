<x-arcade::carousel
  bound
  controls
  :rewind="false"
  :navigation="false"
  :itemsCount="$products->count()"
  :gap="12"
  :breakpoints="[
    640 => ['perView' => 2],
    768 => ['perView' => 3],
    1024 => ['perView' => 4],
    1280 => ['perView' => 5],
    999999 => ['perView' => 6],
  ]"
  class="group-carousel">
  <x-slot name="carouselControls">
    <x-arcade::carousel.prev-button class="hidden group-carousel-hover:block absolute left-2 top-1/2 transform -translate-y-1/2" />
    <x-arcade::carousel.next-button class="hidden group-carousel-hover:block absolute right-2 top-1/2 transform -translate-y-1/2" />
  </x-slot>
  @foreach($products as $product)
    <x-arcade::carousel.slide class="py-1">
      <x-product :product="$product"/>
    </x-arcade::carousel.slide>
  @endforeach
</x-arcade::carousel>
