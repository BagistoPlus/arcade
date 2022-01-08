<div class="group relative border">
  <div class="w-full min-h-64 bg-gray-200 aspect-w-1 aspect-h-1 rounded-t-md overflow-hidden group-hover:opacity-75 lg:aspect-none">
    <img src="{{ $previewImageUrl }}" alt="Front of men&#039;s Basic Tee in black." class="w-full h-full object-center object-cover">
  </div>
  <div class="p-4 text-center">
    <h3 class="text-sm truncate">
      <a href="{{ $url }}">
        <span aria-hidden="true" class="absolute inset-0"></span>
        {{ $product->name }}
      </a>
    </h3>
    <p class="mt-1 text-base font-semibold text-primary">
      {!! $product->getTypeInstance()->getPriceHtml() !!}
    </p>
  </div>
</div>
