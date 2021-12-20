@extends('shop::layouts.default')

@section('page_title')
  {{ trim($product->meta_title) !== "" ? $product->meta_title : $product->name }}
@stop

@push('head')
  <meta name="description" content="{{ trim($product->meta_description) !== "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}"/>
  <meta name="keywords" content="{{ $product->meta_keywords }}"/>

  @if (core()->getConfigData('catalog.rich_snippets.products.enable'))
    <script type="application/ld+json">
      {{ app('Webkul\Product\Helpers\SEO')->getProductJsonLd($product) }}
    </script>
  @endif

  <?php $productBaseImage = productimage()->getProductBaseImage($product); ?>

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $product->name }}" />
  <meta name="twitter:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />
  <meta name="twitter:image:alt" content="" />
  <meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

  <meta property="og:type" content="og:product" />
  <meta property="og:title" content="{{ $product->name }}" />
  <meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />
  <meta property="og:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />
  <meta property="og:url" content="{{ route('shop.productOrCategory.index', $product->url_key) }}" />
@endpush

@arcade_content

  {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

  @include('shop::templates.product')

  {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

@end_arcade_content
