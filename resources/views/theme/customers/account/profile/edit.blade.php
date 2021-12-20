@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.profile.edit-profile.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.edit-profile')

@end_arcade_content
