@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.reviews.product-review-page-title') }} - {{ $product->name }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.products.reviews.index.before', ['product' => $product]) !!}

  @include('shop::templates.reviews.index')

  {!! view_render_event('bagisto.shop.products.reviews.index.after', ['product' => $product]) !!}

@end_arcade_content
