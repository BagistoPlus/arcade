<div class="container py-10">
  <div class="space-y-6 lg:flex lg:space-x-6 lg:space-y-0">
    <div class="flex-none w-full h-56 border lg:w-72"></div>
    <div class="flex-1">
      <div class="mb-4">
        <h1 class="font-bold text-3xl">{{ $category->name }}</h1>
        @if ($category->description)
          <p class="prose">
            {!! arcade_clear_inline_styles($category->description) !!}
          </p>
        @endif
      </div>

      @if($category->image)
        <div class="aspect-w-16 aspect-h-6 lg:aspect-h-3 mb-6">
          <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-center object-cover" />
        </div>
      @endif

      <div>
        <div class="mb-4">
          <label>{{ __('shop::app.products.sort-by') }}</label>
          <select class="border-gray-300" wire:model="sortOrder">
            @foreach ($this->sortOptions as $key => $order)
              <option value="{{ $key }}">
                  {{ __('shop::app.products.' . $order) }}
              </option>
            @endforeach
          </select>
        </div>

        <x-products-grid :products="$this->products" />
      </div>
    </div>
  </div>
</div>
