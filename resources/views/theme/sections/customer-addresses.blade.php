<x-account-layout :title="__('shop::app.customer.account.address.index.title')">
  <x-slot name="actions">
    @unless ($addresses->isEmpty())
      <a
        href="{{ route('customer.address.create') }}"
        class="px-4 py-2 font-medium text-white border cursor-pointer border-gray-700 bg-gray-700"
      >
        {{ __('shop::app.customer.account.address.index.add') }}
      </a>
    @endunless
  </x-slot>

  @if ($addresses->isEmpty())
    <div class="py-6 text-center">
      <p class="mb-6">{{ __('shop::app.customer.account.address.index.empty') }}</p>
      <br>
      <a
        href="{{ route('customer.address.create') }}"
        class="px-4 py-3 font-medium border rounded-sm cursor-pointer hover:bg-opacity-10 bg-opacity-5 border-primary text-primary bg-primary"
      >{{ __('shop::app.customer.account.address.index.add') }}</a>
    </div>
  @else
    <div class="grid grid-cols-1 -m-4 md:grid-cols-2 lg:grid-cols-3">
      @foreach ($addresses as $address)
        <div class="p-6 border-b border-r">
          <h3 class="text-sm font-semibold uppercase">
            {{ __('shop::app.customer.account.address.index.title') }} {{ $loop->iteration }}
          </h3>

          <div class="mt-2">
            <ul class="">
                <li class="">
                    {{ $address->first_name }} {{ $address->last_name }}
                </li>

                <li class="">
                    {{ $address->company_name }}
                </li>

                <li class="">
                    {{ $address->address1 }},
                </li>

                <li class="">
                    {{ $address->state }}, {{ $address->city }}
                </li>

                <li class="">
                    {{ core()->country_name($address->country) }} {{ $address->postcode }}
                </li>

                <li class="">
                    {{ __('shop::app.customer.account.address.index.contact') }}
                    : {{ $address->phone }}
                </li>
            </ul>

            <div class="flex mt-4 space-x-4">
              <a href="{{ route('customer.address.edit', $address->id) }}" class="text-primary hover:underline">
                {{ __('shop::app.customer.account.address.index.edit') }}
              </a>

              <form
                x-data
                action="{{ route('address.delete', $address->id) }}"
                method="post"
                x-on:submit.prevent="confirm('{{ __('shop::app.customer.account.address.index.confirm-delete') }}') && $el.submit()">
                @method('delete')
                @csrf
                <button type="submit" class="text-red-500 hover:underline">
                  {{ __('shop::app.customer.account.address.index.delete') }}
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</x-account-layout>
