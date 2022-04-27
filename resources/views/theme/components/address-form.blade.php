@props([
  'address' => null,
  'submitBtnText' => __('shop::app.customer.account.address.create.submit'),
])

<form {{ $attributes }} method="post">
  @csrf
  @if($address)
    @method('PUT')
  @endif

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.before') !!}

  <div>
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.company_name') }}</span>
      <input
        type="text"
        name="company_name"
        class="mt-1 block w-full border-gray-300"
        value="{{ old('company_name', optional($address)->company_name) }}">
    </label>
    @error('company_name')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.company_name.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.first_name') }}</span>
      <input
        type="text"
        name="first_name"
        class="mt-1 block w-full border-gray-300"
        value="{{ old('first_name', optional($address)->first_name) }}">
    </label>
    @error('first_name')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.first_name.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.last_name') }}</span>
      <input
        type="text"
        name="last_name"
        class="mt-1 block w-full border-gray-300"
        value="{{ old('last_name', optional($address)->last_name) }}">
    </label>
    @error('last_name')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.last_name.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.vat_id') }}</span>
      <span class="text-xs">{{ __('shop::app.customer.account.address.create.vat_help_note') }}</span>

      <input
        type="text"
        name="vat_id"
        class="mt-1 block w-full border-gray-300"
        value="{{ old('vat_id', optional($address)->vat_id) }}">
    </label>
    @error('vat_id')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.vat_id.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.street-address') }}</span>
      <input
        type="text"
        name="address1[]"
        class="mt-1 block w-full border-gray-300"
        value="{{ old('address1', optional($address)->address1) }}">
    </label>
    @error('address1[]')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  @if (
    core()->getConfigData('customer.settings.address.street_lines')
    && core()->getConfigData('customer.settings.address.street_lines') > 1
  )
    @for ($i = 1; $i < core()->getConfigData('customer.settings.address.street_lines'); $i++)
      <div class="mt-4">
        <input
          type="text"
          class="mt-1 block w-full border-gray-300"
          name="address1[{{ $i }}]"
          value="{{ old('address1[' . $i . ']') }}">
      </div>
    @endfor
  @endif

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.street-address.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.country') }}</span>
      <select class="block w-full mt-1 border-gray-300" name="country">
        @foreach(core()->countries() as $country)
          <option value="{{ $country->code }}" @if(old('country', optional($address)->country) === $country->code) selected @endif>
            {{ $country->name }}
          </option>
        @endforeach
      </select>
    </label>
    @error('country')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.state') }}</span>
      <input
        type="text"
        class="mt-1 block w-full border-gray-300"
        name="state"
        value="{{ old('state', optional($address)->state) }}">
    </label>
    @error('state')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.country-state.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.city') }}</span>
      <input
        type="text"
        class="mt-1 block w-full border-gray-300"
        name="city"
        value="{{ old('city', optional($address)->city) }}">
    </label>
    @error('city')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.city.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.postcode') }}</span>
      <input
        type="text"
        class="mt-1 block w-full border-gray-300"
        name="postcode"
        value="{{ old('postcode', optional($address)->postcode) }}">
    </label>
    @error('postcode')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.postcode.after') !!}

  <div class="mt-4">
    <label class="block">
      <span>{{ __('shop::app.customer.account.address.create.phone') }}</span>
      <input
        type="text"
        class="mt-1 block w-full border-gray-300"
        name="phone"
        value="{{ old('phone', optional($address)->phone) }}">
    </label>
    @error('phone')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.phone.after') !!}

  <div class="mt-4">
    <label class="inline-flex items-center">
      <input type="checkbox" name="default_address" {{ old('default_address', optional($address)->default_address) ? 'checked' : '' }}>
      <span class="ml-2">
        {{ __('shop::app.customer.account.address.default-address') }}
      </span>
    </label>
  </div>

  <div class="mt-4">
    <button type="submit" class="px-6 py-3 bg-primary text-white hover:bg-opacity-90">
      {{ $submitBtnText }}
    </button>
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create_form_controls.phone.after') !!}
</form>
