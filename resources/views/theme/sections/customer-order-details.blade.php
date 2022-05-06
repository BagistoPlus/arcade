@php
  $tabs = [
    'info' => true,
    'invoices' => $order->invoices->count() > 0,
    'shipments' => $order->shipments->count() > 0,
    'refunds' => $order->refunds->count() > 0
  ];
@endphp

<x-account-layout :title="__('shop::app.customer.account.order.view.page-tile', ['order_id' => $order->increment_id])">
  <x-slot name="actions">
    @if ($order->canCancel())
      <form
        x-data
        method="post"
        action="{{ route('customer.orders.cancel', $order->id) }}"
        x-on:submit.prevent="confirm('{{ __('shop::app.customer.account.order.view.cancel-confirm-msg') }}') && $el.submit()">
        @csrf
        <button type="submit" class="px-4 py-1 text-white bg-primary">
          {{ __('shop::app.customer.account.order.view.cancel-btn-title') }}
        </button>
      </form>
    @endif
  </x-slot>

  {!! view_render_event('bagisto.shop.customers.account.orders.view.before', ['order' => $order]) !!}

  <div x-data="{ activeTab: 'info'}">
    <ul role="tablist" class="flex items-stretch border-b">
      @foreach ($tabs as $key => $active)
        @if ($active)
          <li>
            <button
              type="button"
              class="px-4 py-2 border-b-2"
              x-bind:class="activeTab === '{{ $key }}' ? 'border-primary text-primary' : 'border-transparent'"
              x-on:click="activeTab = '{{ $key }}'">
              {{ __('shop::app.customer.account.order.view.' . $key) }}
            </button>
          </li>
        @endif
      @endforeach
    </ul>

    <div role="tabpanels">
      @foreach ($tabs as $key => $active)
        @if ($active)
          <section x-show="activeTab === '{{ $key }}'">
            @include('shop::partials.account.order.' . $key)
          </section>
        @endif
      @endforeach
    </div>
  </div>

  <hr class="my-4 border-gray-300">

  @include('shop::partials.account.order.customer')

  {!! view_render_event('bagisto.shop.customers.account.orders.view.after', ['order' => $order]) !!}
</x-account-layout>
