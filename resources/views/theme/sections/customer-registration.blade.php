<div class="py-12">
  <div class="mx-auto max-w-lg">
    <h1 class="text-center text-2xl font-semibold">{{ __('shop::app.customer.signup-form.title') }}</h1>

    <div class="border p-6 mt-6">
      {!! view_render_event('bagisto.shop.customers.signup.before') !!}

      @livewire('register-customer')

      {!! view_render_event('bagisto.shop.customers.signup.after') !!}
    </div>
  </div>
</div>
