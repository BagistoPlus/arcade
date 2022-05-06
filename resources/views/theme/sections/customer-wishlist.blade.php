@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')

<x-account-layout :title="__('shop::app.customer.account.wishlist.title')">
  <x-slot name="actions">
    @unless ($items->isEmpty())
      <form method="POST" action="{{ route('customer.wishlist.removeall') }}"
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-1 text-white bg-primary">
          {{ __('shop::app.customer.account.wishlist.deleteall') }}
        </button>
      </form>
    @endunless
  </x-slot>

  {!! view_render_event('bagisto.shop.customers.account.wishlist.list.before', ['wishlist' => $items]) !!}

  @forelse($items as $item)
    <div class="flex items-center mb-4 pb-2 border-b">
      <div class="flex-none">
        @php
          $image = $item->product->getTypeInstance()->getBaseImage($item);
        @endphp
        <img class="media" src="{{ $image['small_image_url'] }}" alt=""/>
      </div>

      <div class="flex-1">
        <div>
          {{ $item->product->name }}

          @if (isset($item->additional['attributes']))
            <div class="item-options">
                @foreach ($item->additional['attributes'] as $attribute)
                  <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                @endforeach
            </div>
          @endif
        </div>
        <div class="inline-flex mt-4">
          @for ($i = 1; $i <= $reviewHelper->getAverageRating($item->product); $i++)
            <x-heroicon-s-star class="w-4 h-4" />
          @endfor
        </div>
      </div>

      <div class="flex-none">
        <form method="POST" action="{{ route('customer.wishlist.remove', $item->id) }}">
          @csrf
          @method('delete')
          <button type="submit" class="text-gray-600 hover:text-gray-800">
            <x-heroicon-s-trash class="w-5 h-5" />
          </button>
        </form>

        <a href="{{ route('customer.wishlist.move', $item->id) }}" class="mt-2 px-3 py-1 bg-primary text-white text-sm">
          {{ __('shop::app.customer.account.wishlist.move-to-cart') }}
        </a>
      </div>
    </div>
  @empty
    <div class="py-5 text-center">
      {{ __('customer::app.wishlist.empty') }}
    </div>
  @endforelse

  {!! view_render_event('bagisto.shop.customers.account.wishlist.list.after', ['wishlist' => $items]) !!}
</x-account-layout>
