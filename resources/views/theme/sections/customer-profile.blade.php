<x-account-layout :title="__('shop::app.customer.account.profile.index.title')">
  <div class="table w-full max-w-3xl">
    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.before', ['customer' => $customer]) !!}

    <div class="table-row">
      <div class="table-cell py-2">
        {{ __('shop::app.customer.account.profile.fname') }}
      </div>
      <div class="table-cell py-2">{{ $customer->first_name }}</div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.first_name.after', ['customer' => $customer]) !!}

    <div class="table-row">
      <div class="table-cell py-2">
        {{ __('shop::app.customer.account.profile.lname') }}
      </div>
      <div class="table-cell py-2">{{ $customer->last_name }}</div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.last_name.after', ['customer' => $customer]) !!}

    <div class="table-row">
      <div class="table-cell py-2">
        {{ __('shop::app.customer.account.profile.gender') }}
      </div>
      <div class="table-cell py-2">{{ __($customer->gender) }}</div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.gender.after', ['customer' => $customer]) !!}

    <div class="table-row">
      <div class="table-cell py-2">
        {{ __('shop::app.customer.account.profile.dob') }}
      </div>
      <div class="table-cell py-2">{{ $customer->date_of_birth }}</div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.date_of_birth.after', ['customer' => $customer]) !!}

    <div class="table-row">
      <div class="table-cell py-2">
        {{ __('shop::app.customer.account.profile.email') }}
      </div>
      <div class="table-cell py-2">{{ $customer->email }}</div>
    </div>
  </div>

  <div class="mt-6 mb-4 flex">
    <a href="{{ route('customer.profile.edit') }}" class="px-4 py-3 font-medium border cursor-pointer border-primary text-primary">
      {{ __('shop::app.customer.account.profile.index.edit') }}
    </a>

    <form method="POST" action="{{ route('customer.profile.destroy') }}"
      @csrf
      @method('DELETE')
      <button type="submit" class="px-4 py-3 ml-4 font-medium border cursor-pointer border-gray-500 hover:bg-gray-100">
        {{ __('shop::app.customer.account.address.index.delete') }}
      </button>
    </form>
  </div>
</x-account-layout>
