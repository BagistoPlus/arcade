@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.signup-form.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.index')

@end_arcade_content
