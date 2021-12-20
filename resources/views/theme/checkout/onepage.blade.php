@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.checkout.onepage.title') }}
@endsection

@arcade_content

  @include('shop::templates.checkout')

@end_arcade_content
