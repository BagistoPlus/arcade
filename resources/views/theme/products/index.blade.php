@extends('shop::layouts.default')

@section('page_title')
  {{ trim($category->meta_title) !== "" ? $category->meta_title : $category->name }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.products.index.before', ['category' => $category]) !!}

  @include('shop::templates.category')

  {!! view_render_event('bagisto.shop.products.index.after', ['category' => $category]) !!}

@end_arcade_content
