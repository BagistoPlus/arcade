<x-account-layout :title="__('shop::app.customer.account.review.index.title')">
  <x-slot name="actions">
    @unless ($reviews->isEmpty())
      <form
        x-data
        method="POST"
        action="{{ route('customer.review.deleteall') }}"
        x-on:submit.prevent="confirm('{{ __('shop::app.customer.account.review.delete-all.confirmation-message') }}') && $el.submit()">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-1 text-white bg-primary">
          {{ __('shop::app.customer.account.review.delete-all.title') }}
        </button>
      </form>
    @endunless
  </x-slot>

  {!! view_render_event('bagisto.shop.customers.account.reviews.list.before', ['reviews' => $reviews]) !!}

  @forelse($reviews as $review)
    <div class="flex mb-4 pb-2 border-b">
      <div class="flex-none">
        <?php $image = productimage()->getProductBaseImage($review->product); ?>
        <a href="{{ route('shop.productOrCategory.index', $review->product->url_key) }}" title="{{ $review->product->name }}">
          <img class="media" src="{{ $image['small_image_url'] }}" alt=""/>
        </a>
      </div>

      <div class="flex-1">
        <a
          href="{{ route('shop.productOrCategory.index', $review->product->url_key) }}"
          title="{{ $review->product->name }}"
          class="text-primary">
          {{ $review->product->name }}
        </a>

        <div class="flex">
          @for($i=0 ; $i < $review->rating ; $i++)
            <x-heroicon-s-star class="w-4 h-4" />
          @endfor
        </div>

        <div class="mt-1">
          {{ $review->comment }}
        </div>
      </div>

      <div class="flex-none">
        <form
          x-data
          method="POST"
          action="{{ route('customer.review.delete', $review->id) }}"
          x-on:submit.prevent="confirm('{{ __('shop::app.customer.account.review.delete.confirmation-message') }}') && $el.submit()">
          @csrf
          @method('delete')
          <button type="submit" class="text-gray-600 hover:text-gray-800">
            <x-heroicon-s-trash class="w-5 h-5" />
          </button>
        </form>
      </div>
    </div>
  @empty
    <div class="my-10">
      {{ __('customer::app.reviews.empty') }}
    </div>
  @endforelse

  {!! view_render_event('bagisto.shop.customers.account.reviews.list.after', ['reviews' => $reviews]) !!}
</x-account-layout>
