@extends('shop::layouts.default')

@php
  $channel = core()->getCurrentChannel();
  $homeSEO = $channel->home_seo;

  if (isset($homeSEO)) {
      $homeSEO = json_decode($channel->home_seo);
  }
@endphp

@section('page_title', $homeSEO->meta_title ?? config('app.name'))

@push('head')
  @if (isset($homeSEO))
    @isset($homeSEO->meta_title)
      <meta name="title" content="{{ $homeSEO->meta_title }}" />
    @endisset

    @isset($homeSEO->meta_description)
      <meta name="description" content="{{ $homeSEO->meta_description }}" />
    @endisset

    @isset($homeSEO->meta_keywords)
      <meta name="keywords" content="{{ $homeSEO->meta_keywords }}" />
    @endisset
  @endif
@endpush

@arcade_content

  @arcade_slot('bagisto.shop.home.content.before')

  @include('shop::templates.index')

  @arcade_slot('bagisto.shop.home.content.after')

@end_arcade_content
