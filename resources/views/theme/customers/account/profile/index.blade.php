@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.profile.index.title') }}
@endsection

@arcade_content

  @include('shop::templates.account.profile')

@end_arcade_content
