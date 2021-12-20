@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.address.edit.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.edit-address')

@end_arcade_content
