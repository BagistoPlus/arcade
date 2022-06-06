<div x-data="ArcadeProductBundler({ config: @js($config) })">
  <h3 class="font-semibold text-base">
    {{ __('shop::app.products.customize-options') }}
  </h3>

  <div class="divide-y">
    @foreach($config['options'] as $option)
      <div class="py-3">
        <label>
          <span class="font-semibold text-base">
            {{ $option['label'] }}
          </span>
          @if($option['type'] === 'select')
            <select
              class="block w-full mt-1"
              x-model.number="selectedProducts[{{ $option['id'] }}]"
              wire:model.defer="data.bundle_options.{{ $option['id'] }}.0"
            >
              <option value="">{{ __('shop::app.products.choose-selection') }}</option>
              @foreach($option['products'] as $product)
                <option>
                  {{ $product['name'] }} + {{ $product['price']['final_price']['formated_price'] }}
                </option>
              @endforeach
            </select>
          @elseif($option['type'] === 'radio')
            <div class="mt-1">
              @foreach($option['products'] as $product)
                <label class="block">
                  <input
                    type="radio"
                    name="{{ $option['label'] }}"
                    value="{{ $product['id'] }}"
                    x-model.number="selectedProducts[{{ $option['id'] }}]"
                    wire:model.defer="data.bundle_options.{{ $option['id'] }}.0"
                  >
                  <span>
                    {{ $product['name'] }}
                  </span>
                  <span class="ml-2">
                    + {{ $product['price']['final_price']['formated_price'] }}
                  </span>
                </label>
              @endforeach
            </div>
          @elseif($option['type'] === 'checkbox')
            <div class="mt-1">
              @foreach($option['products'] as $product)
                <label class="block">
                  <input
                    type="checkbox"
                    name="{{ $option['label'] }}"
                    value="{{ $product['id'] }}"
                    x-model.number="selectedProducts[{{ $option['id'] }}]"
                    wire:model.defer="data.bundle_options.{{ $option['id'] }}"
                  >
                  <span>
                    {{ $product['name'] }}
                  </span>
                  <span class="ml-2">
                    + {{ $product['price']['final_price']['formated_price'] }}
                  </span>
                </label>
              @endforeach
            </div>
          @elseif($option['type'] === 'multiselect')
            <select
              multiple
              class="block w-full mt-1"
              x-model.number="selectedProducts[{{ $option['id'] }}]"
              wire:model.defer="data.bundle_options.{{ $option['id'] }}"
            >
              @unless($option['is_required'])
                <option value="0">{{ __('shop::app.products.none') }}</option>
              @endif
              @foreach($option['products'] as $product)
                <option>
                  {{ $product['name'] }} + {{ $product['price']['final_price']['formated_price'] }}
                </option>
              @endforeach
            </select>
          @endif
        </label>

        @if($option['type'] === 'select' || $option['type'] === 'radio')
          <x-arcade::quantity-selector
            class="my-4"
            :label="__('shop::app.products.quantity')"
            wire:on-input="$set('data.bundle_option_qty.{{ $option['id'] }}', $event.detail, true)"
          />
        @endif
      </div>
    @endforeach
  </div>

  <hr class="border-gray-200 my-2">

  <div class="mt-2">
    <h3 class="font-semibold text-base">
      {{ __('shop::app.products.your-customization') }}
    </h3>

    <x-arcade::quantity-selector
      class="my-4"
      :label="__('shop::app.products.quantity')"
      wire:on-input="$set('quantity', $event.detail, true)"
    />

    <div class="mt-4">
      <label>{{ __('shop::app.products.total-amount') }}</label>
      <div class="text-xl font-medium text-primary" x-text="formatedTotalPrice"></div>

      <ul wire:ignore class="mt-2 space-y-2">
        <template x-for="(option) in options" x-bind:key="option.id">
          <li>
            <span x-text="option.label" class="font-medium"></span>
            <div>
              <template x-for="product in option.products" x-bind:key="product.id">
                <template x-if="product.is_default">
                  <div>
                    <span x-text="product.qty"></span>
                    x
                    <span x-text="product.name"></span>
                  </div>
                </template>
              </template>
            </div>
          </li>
        </template>
      </ul>
    </div>
  </div>
</div>
