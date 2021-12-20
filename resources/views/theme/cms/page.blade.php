@extends('shop::layouts.default')

@section('page_title')
  {{ $page->page_title }}
@endsection

@push('head')
  <meta name="title" content="{{ $page->meta_title }}" />
  <meta name="description" content="{{ $page->meta_description }}" />
  <meta name="keywords" content="{{ $page->meta_keywords }}" />
@endpush

@arcade_content

  @include('shop::templates.page')

@end_arcade_content
