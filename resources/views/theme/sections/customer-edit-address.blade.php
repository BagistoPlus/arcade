<x-account-layout :title="__('shop::app.customer.account.address.edit.page-title')">
  {!! view_render_event('bagisto.shop.customers.account.address.edit.before', ['address' => $address]) !!}

  <div class="w-full max-w-xl">
    <x-address-form
      :action="route('customer.address.update', $address->id)"
      :address="$address"
    />
  </div>

  {!! view_render_event('bagisto.shop.customers.account.address.edit.after', ['address' => $address]) !!}
</x-account-layout>
