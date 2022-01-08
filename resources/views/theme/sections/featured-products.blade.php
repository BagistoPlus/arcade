<div class="py-10">
  <div class="container">
    @if($section->settings->heading)
      <h3 class="text-center text-2xl font-semibold">{{ $section->settings->heading }}</h3>
    @endif

    @if($section->settings->subheading)
      <p class="text-center max-w-lg mx-auto mt-2">
        {{ $section->settings->subheading }}
      </p>
    @endif

    <div class="mt-4">
      <x-products-grid :products="$getProducts()" />
    </div>
  </div>
</div>
