@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.address.create.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.add-address')

@end_arcade_content
