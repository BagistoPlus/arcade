<form method="POST" wire:submit.prevent="submit">
  @csrf

  {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

  <div>
    @if (session()->has('error'))
      <div class="p-4 bg-red-100 text-red-500">
        {{ session('error') }}
      </div>
    @endif
  </div>

  <div class="block mt-4">
    <label class="block" for="email">
      {{ __('shop::app.customer.login-form.email') }}
    </label>
    <input
      required
      type="email"
      id="email"
      class="mt-1 block w-full border-gray-300"
      wire:model="email">
    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  <div class="block mt-4">
    <label class="block" for="password">
      {{ __('shop::app.customer.signup-form.password') }}
    </label>
    <input
      required
      type="password"
      id="password"
      class="mt-1 block w-full border-gray-300"
      wire:model="password">
    @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
  </div>

  <div class="mt-4">
    <a href="{{ route('customer.forgot-password.create') }}" class="text-primary">
      {{ __('shop::app.customer.login-form.forgot_pass') }}
    </a>

    <div class="mt-10">
      @if (Cookie::has('enable-resend'))
        @if (Cookie::get('enable-resend') == true)
          <a href="{{ route('customer.resend.verification-email', Cookie::get('email-for-resend')) }}">{{ __('shop::app.customer.login-form.resend-verification') }}</a>
        @endif
      @endif
    </div>
  </div>

  <button
    type="submit"
    class="mt-4 block w-full py-2 bg-primary text-white shadow hover:shadow-lg"
    wire:loading.class="text-transparent relative pointer-events-none"
    wire:target="submit">
    {{ __('shop::app.customer.login-form.button_title') }}
    <div wire:loading="submit" wire:target="submit" class="text-white absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
      <div class="w-4 h-4 rounded-full border-2 border-current border-r-transparent animate animate-spin"></div>
    </div>
  </button>

  <div class="mt-6 text-center">
    {{ __('shop::app.customer.login-text.no_account') }} -
    <a href="{{ route('customer.register.index') }}" class="text-primary">
      {{ __('shop::app.customer.login-text.title') }}
    </a>
  </div>
</form>
