@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.checkout.success.title') }}
@endsection

@arcade_content

  @include('shop::templates.checkout-success')

@end_arcade_content
