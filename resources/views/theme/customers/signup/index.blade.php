@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.customer.signup-form.page-title') }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.customers.signup.index.before') !!}

  @include('shop::templates.auth.register')

  {!! view_render_event('bagisto.shop.customers.signup.index.after') !!}

@end_arcade_content
