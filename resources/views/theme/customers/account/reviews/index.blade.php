@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.review.index.page-title') }}
@endsection

@arcade_content

  @include('shop::templates.account.reviews')

@end_arcade_content
