<form method="POST" wire:submit.prevent="submit">
  @csrf

  {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

  <div class="block">
    <label class="block" for="first_name">
      {{ __('shop::app.customer.signup-form.firstname') }}
    </label>
    <input
      required
      type="text"
      id="first_name"
      class="mt-1 block w-full border-gray-300"
      placeholder=""
      wire:model="state.first_name">
    @error('first_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.signup_form_controls.firstname.after') !!}

  <div class="block mt-4">
    <label class="block" for="last_name">
      {{ __('shop::app.customer.signup-form.lastname') }}
    </label>
    <input
      required
      type="text"
      id="lastname"
      class="mt-1 block w-full border-gray-300"
      wire:model="state.last_name">
    @error('last_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.signup_form_controls.lastname.after') !!}

  <div class="block mt-4">
    <label class="block" for="email">
      {{ __('shop::app.customer.signup-form.email') }}
    </label>
    <input
      required
      type="email"
      id="email"
      class="mt-1 block w-full border-gray-300"
      wire:model="state.email">
    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.signup_form_controls.email.after') !!}

  <div class="block mt-4">
    <label class="block" for="password">
      {{ __('shop::app.customer.signup-form.password') }}
    </label>
    <input
      required
      type="password"
      id="password"
      class="mt-1 block w-full border-gray-300"
      wire:model="state.password">
    @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  <div class="block mt-4">
    <label class="block" for="password_confirmation">
      {{ __('shop::app.customer.signup-form.confirm_pass') }}
    </label>
    <input
      required
      type="password"
      id="password_confirmation"
      class="mt-1 block w-full border-gray-300"
      wire:model="state.password_confirmation">
    @error('password_confirmation') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  {!! view_render_event('bagisto.shop.customers.signup_form_controls.email.password') !!}

  @if (core()->getConfigData('customer.settings.newsletter.subscription'))
    <div class="mt-4">
      <label class="inline-flex items-center">
        <input type="checkbox" wire:model="state.subscribed_to_news_letter">
        <span class="ml-2">{{ __('shop::app.customer.signup-form.subscribe-to-newsletter') }}</span>
      </label>
    </div>
  @endif

  <button
    type="submit"
    class="mt-4 block w-full py-2 bg-primary text-white shadow hover:shadow-lg"
    wire:loading.class="text-transparent relative pointer-events-none"
    wire:target="submit">
    {{ __('shop::app.customer.signup-form.button_title') }}
    <div wire:loading="submit" wire:target="submit" class="absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
      <div class="w-4 h-4 rounded-full border-2 border-r-transparent animate animate-spin"></div>
    </div>
  </button>

  <div class="mt-6 text-center">
    {{ __('shop::app.customer.signup-text.account_exists') }} -
    <a href="{{ route('customer.session.index') }}" class="text-primary">
      {{ __('shop::app.customer.signup-text.title') }}
    </a>
  </div>
</form>
