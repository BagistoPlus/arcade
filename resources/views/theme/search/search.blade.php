@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.search.page-title') }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.search.search.before', ['results' => $results]) !!}

  @include('shop::templates.search')

  {!! view_render_event('bagisto.shop.search.search.after', ['results' => $results]) !!}

@end_arcade_content
