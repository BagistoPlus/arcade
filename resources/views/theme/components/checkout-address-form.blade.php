<div
  x-data="{ showNewAddressForm: @entangle($newFormToggle) }"
  {{ $attributes }}
>
  <div class="flex justify-between items-center">
    <h2 class="text-2xl font-bold leading-tight">
      {{ $title }}
    </h2>
    @auth('customer')
      <button
        type="button"
        class="border px-2 py-1 hover:bg-gray-100"
        x-text="
          showNewAddressForm ?
            '{{ __('shop::app.checkout.onepage.back') }}' :
            '{{ __('shop::app.checkout.onepage.new-address')}}'
          "
        x-on:click="showNewAddressForm = !showNewAddressForm">
      </button>
    @endauth
  </div>

  <div x-show="!showNewAddressForm" class="mt-6">
    <div class="flex">
      @foreach($addresses as $address)
        <label for="{{ $address->id }}" class="p-4 flex flex-start border w-full sm:w-1/2 xl:1/3">
          <input
            type="radio"
            id="{{ $address->id }}"
            name="{{ $name}}AddressId"
            value="{{ $address->id }}"
            wire:model="{{ $name }}Address.address_id"
            class="flex-none"
          />
          <div class="flex-1 ml-3 -mt-1">
            @if($address->company_name)
              <p class="">{{ $address->company_name }}</p>
            @endif
            <p class="font-semibold">{{ $address->first_name }} {{ $address->last_name }},</p>
            <p>{{ $address->address1 }},</p>
            <p>{{ $address->city }},</p>
            <p>{{ $address->state }},</p>
            <p>{{ $address->country }} {{ $address->postcode }}</p>
            <p class="mt-1">
              <span class="font-semibold">{{ __('shop::app.customer.account.address.index.contact') }}:</span>
              <span>{{ $address->phone }}</span>
            </p>
          </div>
        </label>
      @endforeach
    </div>

    @error($name.'Address.address_id')
      <div class="mt-4 text-sm text-red-500 italic">{{ $message }}</div>
    @enderror
  </div>

  <div x-show="showNewAddressForm" class="mt-6">
    @if ($name === 'billing')
      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.checkout.onepage.company-name') }}</span>
          <input
            type="text"
            class="mt-1 block w-full border-gray-300"
            wire:model="{{ $name }}Address.company_name">
        </label>
        @error($name.'Address.company_name')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>
    @endif

    <div class="mt-4 flex flex-wrap md:space-x-6">
      <div class="w-full md:flex-1">
        <label class="block">
          <span class="text-gray-700">{{ __('shop::app.checkout.onepage.first-name') }}</span>
          <input
            type="text"
            class="mt-1 block w-full border-gray-300"
            wire:model="{{ $name }}Address.first_name">
        </label>
        @error($name.'Address.first_name')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      <div class="w-full md:flex-1">
        <label class="block">
          <span class="text-gray-700">{{ __('shop::app.checkout.onepage.last-name') }}</span>
          <input
            type="text"
            class="mt-1 block w-full border-gray-300"
            wire:model="{{ $name }}Address.last_name">
        </label>
        @error($name.'Address.last_name')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.email') }}</span>
        <input
          type="email"
          class="mt-1 block w-full border-gray-300"
          wire:model="{{ $name }}Address.email">
      </label>
      @error($name.'Address.email')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.address1') }}</span>
        <input
          type="text"
          class="mt-1 block w-full border-gray-300"
          wire:model="{{ $name }}Address.address1.0">
      </label>
      @error($name.'Address.address1.0')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    @if (
      core()->getConfigData('customer.settings.address.street_lines')
      && core()->getConfigData('customer.settings.address.street_lines') > 1
    )
      @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
        <div class="mt-4">
          <label class="block">
            <input
              type="text"
              class="mt-1 block w-full border-gray-300"
              wire:model="{{ $name }}Address.address1.{{ $i }}">
          </label>
        </div>
      @endfor
    @endif

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.city') }}</span>
        <input
          type="text"
          class="mt-1 block w-full border-gray-300"
          wire:model="{{ $name }}Address.city">
      </label>
      @error($name.'Address.city')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.country') }}</span>
        <select class="block w-full mt-1 border-gray-300" wire:model="{{ $name }}Address.country">
          @foreach(core()->countries() as $country)
            <option value="{{ $country->code }}">
              {{ $country->name }}
            </option>
          @endforeach
        </select>
      </label>
      @error($name.'Address.country')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.state') }}</span>
        <input
          type="text"
          class="mt-1 block w-full border-gray-300"
          wire:model="{{ $name }}Address.state">
      </label>
      @error($name.'Address.state')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.postcode') }}</span>
        <input
          type="text"
          class="mt-1 block w-full border-gray-300"
          wire:model="{{ $name }}Address.postcode">
      </label>
      @error($name.'Address.postcode')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    <div class="mt-4">
      <label class="block">
        <span>{{ __('shop::app.checkout.onepage.phone') }}</span>
        <input
          type="text"
          class="mt-1 block w-full border-gray-300"
          wire:model="{{ $name }}Address.phone">
      </label>
      @error($name.'Address.phone')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
      @enderror
    </div>

    @auth('customer')
      <div class="mt-4">
        <label class="inline-flex items-center">
          <input type="checkbox" wire:model="{{ $name }}Address.save_as_address">
          <span class="ml-2">
            {{ __('shop::app.checkout.onepage.save_as_address') }}
          </span>
        </label>
      </div>
    @endauth
  </div>

  @if ($name === 'billing' && $cart->haveStockableItems())
    <div class="mt-4">
      <label class="inline-flex items-center">
        <input type="checkbox" wire:model="{{ $name }}Address.use_for_shipping">
        <span class="ml-2">
          {{ __('shop::app.checkout.onepage.use_for_shipping') }}
        </span>
      </label>
    </div>
  @endif
</div>
