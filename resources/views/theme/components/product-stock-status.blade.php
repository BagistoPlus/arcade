@php
  $classes = [
    'in-stock' => 'text-green-500',
    'available-for-order' => '',
    'out-of-stock' => 'text-red-500'
  ];
@endphp

{!! view_render_event('bagisto.shop.products.view.stock.before', ['product' => $product]) !!}

<div class="font-medium {{ $classes[$status]}}">
  {{ $statusText }}
</div>

{!! view_render_event('bagisto.shop.products.view.stock.after', ['product' => $product]) !!}
