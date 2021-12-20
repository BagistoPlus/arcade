@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.downloadable_products.title') }}
@endsection

@arcade_content

  @include('shop::templates.account.downloads')

@end_arcade_content
