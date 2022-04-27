<x-account-layout :title="__('shop::app.customer.account.profile.edit-profile.title')">
  {!! view_render_event('bagisto.shop.customers.account.profile.edit.before', ['customer' => $customer]) !!}

  <form method="POST" wire:submit.prevent="submit">
    @csrf

    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.before', ['customer' => $customer]) !!}

    <div class="w-full max-w-xl">
      <div>
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.fname') }}</span>
          <input
            type="text"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="firstName">
        </label>
        @error('first_name')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.first_name.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.lname') }}</span>
          <input
            type="text"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="lastName">
        </label>
        @error('last_name')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.last_name.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.gender') }}</span>
          <select name="gender" wire:model.lazy="gender" class="block w-full mt-1 border-gray-300">
            <option value=""></option>
            <option value="Other">{{ __('shop::app.customer.account.profile.other') }}</option>
            <option value="Male">{{ __('shop::app.customer.account.profile.male') }}</option>
            <option value="Female">{{ __('shop::app.customer.account.profile.female') }}</option>
          </select>
        </label>
        @error('gender')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.gender.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.dob') }}</span>
          <input
            type="date"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="dateOfBirth">
        </label>
        @error('date_of_birth')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.date_of_birth.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.email') }}</span>
          <input
            type="email"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="email">
        </label>
        @error('email')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.email.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.phone') }}</span>
          <input
            type="text"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="phone">
        </label>
        @error('phone')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.phone.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.opassword') }}</span>
          <input
            type="password"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="oldPassword">
        </label>
        @error('oldpassword')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.oldpassword.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.password') }}</span>
          <input
            type="password"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="password">
        </label>
        @error('password')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      {!! view_render_event('bagisto.shop.customers.account.profile.edit.password.after') !!}

      <div class="mt-4">
        <label class="block">
          <span>{{ __('shop::app.customer.account.profile.cpassword') }}</span>
          <input
            type="password"
            class="mt-1 block w-full border-gray-300"
            wire:model.lazy="passwordConfirmation">
        </label>
        @error('password_confirmation')
          <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
      </div>

      @if (core()->getConfigData('customer.settings.newsletter.subscription'))
        <div class="mt-4">
          <label class="inline-flex items-center">
            <input type="checkbox" wire:model.lazy="subscribedToNewsletter">
            <span class="ml-2">
              {{ __('shop::app.customer.signup-form.subscribe-to-newsletter') }}
            </span>
          </label>
        </div>
      @endif
    </div>

    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.after', ['customer' => $customer]) !!}

    <div class="mt-4">
      <button
        type="submit"
        class="px-6 py-3 bg-primary text-white hover:bg-opacity-90"
        wire:loading.class="text-transparent relative pointer-events-none">
        {{ __('shop::app.customer.account.profile.submit') }}
        <div wire:loading="submit" wire:target="submit" class="text-white absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
          <div class="w-4 h-4 rounded-full border-2 border-current border-r-transparent animate animate-spin"></div>
        </div>
      </button>
    </div>
  </form>

  {!! view_render_event('bagisto.shop.customers.account.profile.edit.after', ['customer' => $customer]) !!}
</x-account-layout>
