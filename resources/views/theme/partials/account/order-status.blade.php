@php
  $styles = [
    'pending' => 'bg-yellow-500',
    'pending_payment' => 'bg-yellow-500',
    'processing' => 'bg-green-500',
    'completed' => 'bg-green-500',
    'canceled' => 'bg-red-500',
    'closed' => 'bg-blue-500',
    'fraud' => 'bg-red-500',
  ]
@endphp
<span class="rounded-full px-2 py-1 text-white {{ $styles[$value] ?? '' }}">
  {{ __('shop::app.customer.account.order.index.' . $value === 'pending_payment' ? 'pending-payment' : $value) }}
</span>
