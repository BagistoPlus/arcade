@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.checkout.cart.title') }}
@endsection

@arcade_content

  @include('shop::templates.cart')

@end_arcade_content
