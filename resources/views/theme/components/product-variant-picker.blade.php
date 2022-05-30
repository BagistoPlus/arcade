<div
  x-data="ArcadeProductVariantPicker({
    product: @js($product),
    options: @js($productOptions),
  })"
  class="mt-4"
>
  @foreach($productOptions['attributes'] as $attribute)
    <div class="mb-2">
      <label class="font-medium mb-1 block">
        {{ $attribute['label'] }}
      </label>
      @if($isAttributeDropdown($attribute))
        <div class>
          <select
            class="w-64 border-gray-300"
            x-model="attributeValues[{{ $attribute['id'] }}]"
            x-on:change="onOptionSelected({{ $attribute['id'] }}, $event.target.value)">
            <option value="" disabled>{{ __('shop::app.products.choose-option') }}</option>
            @foreach($attribute['options'] as $option)
              <option
                value="{{ $option['id'] }}"
                x-bind:disabled="!isAttributeOptionAvailable({{ $attribute['id'] }}, {{ $option['id'] }})"
              >
                {{ $option['label'] }}
              </option>
            @endforeach
          </select>
        </div>
      @else
        <div class="flex">
          @foreach($attribute['options'] as $option)
            <label class="mr-2 cursor-pointer">
              <input
                type="radio"
                class="hidden"
                value="{{ $option['id'] }}"
                x-model="attributeValues[{{ $attribute['id'] }}]"
                x-bind:disabled="!isAttributeOptionAvailable({{ $attribute['id'] }}, {{ $option['id'] }})"
                x-on:input="onOptionSelected({{ $attribute['id'] }}, $event.target.value)"
              >
              @if($attribute['swatch_type'] === 'color')
                <span
                  class="block w-10 h-10 border"
                  style="background-color: {{ $option['swatch_value'] }}"
                  x-bind:class="{'ring-2 ring-black': attributeValues[{{ $attribute['id'] }}] == {{ $option['id'] }} }"
                ></span>
              @elseif($attribute['swatch_type'] === 'image')
                <img class="w-10 h-10 border" src="{{ $option['swatch_value'] }}">
              @elseif($attribute['swatch_type'] === 'text')
                <span>{{ $option['swatch_value'] }}</span>
              @endif
            </label>
          @endforeach
        </div>
      @endif
    </div>
  @endforeach
</div>
