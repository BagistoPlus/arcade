<x-account-layout :title="__('shop::app.customer.account.address.create.page-title')">
  {!! view_render_event('bagisto.shop.customers.account.address.create.before') !!}

  <div class="w-full max-w-xl">
    <x-address-form :action="route('customer.address.store')" />
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}
</x-account-layout>
