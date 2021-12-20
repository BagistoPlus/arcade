@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.customer.forgot-password.page_title') }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.customers.forget_password.before') !!}

  @include('shop::templates.auth.forgot-password')

  {!! view_render_event('bagisto.shop.customers.forget_password.after') !!}

@end_arcade_content
