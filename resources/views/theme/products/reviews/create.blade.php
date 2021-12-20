@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.reviews.add-review-page-title') }} - {{ $product->name }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.products.reviews.create.before', ['product' => $product]) !!}

  @include('shop::templates.reviews.create')

  {!! view_render_event('bagisto.shop.products.reviews.create.after', ['product' => $product]) !!}

@end_arcade_content
