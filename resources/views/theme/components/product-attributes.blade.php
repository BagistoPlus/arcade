{!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

@if($hasCustomAttributes())
  <x-arcade::accordion class="mt-4">
    <x-arcade::accordion.item :title="__('shop::app.products.specification')">
      <div class="px-6 py-3">
        @foreach ($customAttributes as $attribute)
        <dl>
          <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium">
              {{ $attribute['label'] ?? $attribute['admin_name'] }}
            </dt>
            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
              @if ($attribute['type'] == 'file' && $attribute['value'])
                <a  href="{{ route('shop.product.file.download', [$product->product_id, $attribute['id']])}}">
                  <x-heroicon-o-download class="inline w-5 h-5" />
                </a>
              @elseif ($attribute['type'] == 'image' && $attribute['value'])
                <a href="{{ route('shop.product.file.download', [$product->product_id, $attribute['id']])}}">
                  <img src="{{ Storage::url($attribute['value']) }}" style="height: 20px; width: 20px;" alt=""/>
                </a>
              @else
                {{ $attribute['value'] }}
              @endif
            </dd>
          </div>
        </dl>
        @endforeach
      </div>
    </x-arcade::accordion.item>
  </x-arcade::accordion>
@endif

{!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!}
