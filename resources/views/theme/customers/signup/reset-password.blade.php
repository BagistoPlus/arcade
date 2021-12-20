@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.customer.reset-password.title') }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.customers.reset_password.before') !!}

  @include('shop::templates.auth.reset-password')

  {!! view_render_event('bagisto.shop.customers.reset_password.after') !!}

@end_arcade_content
