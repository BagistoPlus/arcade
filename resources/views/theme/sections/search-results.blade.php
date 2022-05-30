<div class="py-10">
  <div class="container">
    @unless($results)
      <p class="text-center">
        {{  __('shop::app.search.no-results') }}
      </p>
    @else
      @if($results->isEmpty())
        <div>
          <h2>{{ __('shop::app.products.whoops') }}</h2>
          <span>{{ __('shop::app.search.no-results') }}</span>
        </div>
      @else
        <div class="text-center mb-6">
          <span>
            <span class="font-medium">{{ $results->total() }} </span>

            {{ ($results->total() == 1) ? __('shop::app.search.found-result') : __('shop::app.search.found-results') }}
          </span>
        </div>
        <div>
          <x-products-grid :products="$results" />
        </div>
      @endif
    @endif

  </div>
</div>
