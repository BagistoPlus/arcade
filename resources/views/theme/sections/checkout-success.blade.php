<section class="container py-16">
  <div class="my-6 prose max-w-full">
    <h1 class="font-semibold text-3xl">
      {{ __('shop::app.checkout.success.thanks') }}
    </h1>

    <p>{{ __('shop::app.checkout.success.order-id-info', ['order_id' => $order->increment_id]) }}</p>

    <p>{{ __('shop::app.checkout.success.info') }}</p>

    {{ view_render_event('bagisto.shop.checkout.continue-shopping.before', ['order' => $order]) }}

    <div class="mt-10">
      <a
        href="{{ route('shop.home.index') }}"
        class="text-white bg-black cursor-pointer hover:bg-opacity-90 px-6 py-4 no-underline"
      >
        {{ __('shop::app.checkout.cart.continue-shopping') }}
      </a>
    </div>

    {{ view_render_event('bagisto.shop.checkout.continue-shopping.after', ['order' => $order]) }}
  </div>
</section>
