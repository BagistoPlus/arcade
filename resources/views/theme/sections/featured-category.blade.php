<div class="container py-16">
  @if ($category)
    <div class="flex justify-between">
      <h2 class="text-xl font-semibold text-on-surface-variant">
        {{ $section->settings->heading ?: $category->name . ' collection' }}
      </h2>
      <a href="{{ url()->to($category->translations[0]->url_path) }}" class="hover:underline">
        {{ __('arcade::app.sections.featured-category.view-all') }}
        <x-heroicon-o-arrow-right class="inline w-4 h-4"/>
      </a>
    </div>

    <div class="mt-2">
      {{-- @if($section->settings->layout === 'vertical' && !$section->settings->stack_products)
        <x-products-carousel
          :products="$category->products->take($section->settings->products_to_show)"
        />
      @else --}}
        <x-products-grid
          :products="$products"
          :layout="$section->settings->layout"
        />
      {{-- @endif --}}
    </div>
  @endif
</div>
