
@livewireScripts
<script async type="text/javascript" src="{{ asset('vendor/arcade/shop/shop.js') }}"></script>

@stack('scripts')

@if (request()->route()->getName() == 'shop.checkout.onepage.index')
  @stack('checkout_scripts')
@endif
