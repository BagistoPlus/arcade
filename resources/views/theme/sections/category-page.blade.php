<div class="container py-10">
  <div class="space-y-6 lg:flex lg:space-x-6 lg:space-y-0">
    <div class="hidden flex-none h-56 lg:block lg:w-72">
      <x-product-filters wire :filters="$this->filterAttributes" />
    </div>
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
        <div class="mb-6 flex justify-between items-center">
          <div class="flex space-x-6">
            <div>
              <label>{{ __('shop::app.products.sort-by') }}</label>
              <select class="border-gray-300" wire:model="sortOrder">
                @foreach ($this->sortOptions as $key => $order)
                  <option value="{{ $key }}">
                      {{ __('shop::app.products.' . $order) }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label>{{ __('shop::app.products.show') }}</label>
              <select class="border-gray-300" wire:model="perPage">
                @foreach ($this->itemsPerPageOptions as $limit)
                  <option value="{{ $limit }}">
                    {{ $limit }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div>
            <span class="hidden lg:inline">
              {{ __('shop::app.products.pager-info', ['showing' => $this->products->firstItem() . '-' . $this->products->lastItem(), 'total' => $this->products->total()]) }}
            </span>
          </div>
        </div>

        <x-products-grid :products="$this->products" />
      </div>
    </div>
  </div>
</div>
