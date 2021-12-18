@php
  $gridSize = [
    'vertical' => 'gap-2 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6',
    'horizontal' => 'gap-3 grid-cols-1 md:grid-cols-2 xl:grid-cols-4',
  ]
@endphp

<div class="grid {{ $gridSize[$layout] }}">
  @foreach($products as $product)
    <div>
      <x-product :product="$product" :layout="$layout" />
    </div>
  @endforeach
</div>
