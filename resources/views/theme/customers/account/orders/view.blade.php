@extends('shop::layouts.account')

@section('page_title')
  {{ __('shop::app.customer.account.order.view.page-tile', ['order_id' => $order->increment_id]) }}
@endsection

@arcade_content

  @include('shop::templates.account.order-details')

@end_arcade_content
