@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.address.index.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.addresses')

@end_arcade_content
