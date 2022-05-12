<div {{ $attributes->merge(['class' => 'grid gap-4 lg:gap-6 place-content-center grid-cols-2 md:grid-cols-3 lg:grid-cols-4']) }}>
  @foreach($products as $product)
    <div>
      <x-product :product="$product" />
    </div>
  @endforeach
</div>
