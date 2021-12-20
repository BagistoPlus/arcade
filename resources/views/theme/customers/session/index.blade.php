@extends('shop::layouts.default')

@section('page_title')
  {{ __('shop::app.customer.login-form.page-title') }}
@endsection

@arcade_content

  {!! view_render_event('bagisto.shop.customers.session.index.before') !!}

  @include('shop::templates.auth.login')

  {!! view_render_event('bagisto.shop.customers.session.index.after') !!}

@end_arcade_content
