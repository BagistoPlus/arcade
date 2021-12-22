@php
  $category = arcade_get_category($section->settings->category);
@endphp

<div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
  <div class="flex justify-between">
    <h3 class="text-xl font-semibold text-on-surface-variant">
      {{ $section->settings->heading ?: $category->name . ' collection' }}
    </h3>
    <a href="{{ url()->to($category->translations[0]->url_path) }}" class="hover:underline">
      View all
      <x-heroicon-o-arrow-right class="inline w-4 h-4"/>
    </a>
  </div>

  <div class="mt-2">
    @if($section->settings->layout === 'vertical' && !$section->settings->stack_products)
      <x-products-carousel
        :products="$category->products->take($section->settings->products_to_show)"
      />
    @else
      <x-products-grid
        :products="$category->products->take($section->settings->products_to_show)"
        :layout="$section->settings->layout"
      />
    @endif
  </div>
</div>
