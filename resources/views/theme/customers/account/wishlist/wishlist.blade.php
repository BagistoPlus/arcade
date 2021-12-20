@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.wishlist.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.wishlist')

@end_arcade_content
