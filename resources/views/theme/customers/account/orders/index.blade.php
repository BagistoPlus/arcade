@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.order.index.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.orders')

@end_arcade_content
