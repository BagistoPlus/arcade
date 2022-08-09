<footer class="bg-surface-variant text-on-surface-variant">
  <div class="container py-10">
    <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
      @foreach($section->blocks as $block)
        <div>
          @if($block->type === 'about')
            <h3 class="mb-4 text-sm font-semibold text-gray-800 uppercase">
              {{ $block->settings->heading }}
            </h3>
            <p class="text-gray-600">
              {{ $block->settings->content }}
            </p>
          @elseif($block->type === 'quick-links')
            <h3 class="mb-4 text-sm font-semibold text-gray-800 uppercase">
              {{ $block->settings->heading }}
            </h3>
            <div class="flex justify-between">
              <ul class="text-gray-600">
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'return-policy') }}" class="hover:underline">
                    {{ __('Order and Returns') }}
                  </a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'payment-policy') }}" class="hover:underline">
                    {{ __('Payment Policy') }}
                  </a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'shipping-policy') }}" class="hover:underline">
                    {{ __('Shipping Policy') }}
                  </a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'privacy-policy') }}" class="hover:underline">
                    {{ __('Privacy Policy') }}
                  </a>
                </li>
              </ul>
              <ul class="text-gray-600">
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'cutomer-service') }}" class="hover:underline">
                    {{ __('Customer Service') }}
                  </a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'whats-new') }}" class="hover:underline">
                    {{ __('What\'s New') }}
                  </a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('shop.cms.page', 'contact-us') }}" class="hover:underline">
                    {{ __('Contact Us') }}
                  </a>
                </li>
              </ul>
            </div>
          @elseif($block->type === 'newsletter')
            <h3 class="mb-4 text-sm font-semibold text-gray-800 uppercase">
              {{ $block->settings->heading }}
            </h3>
            <p class="text-gray-600">
              {{ $block->settings->content }}
            </p>
            <form action="{{ route('shop.subscribe') }}" class="relative mt-4">
              <input
                required
                type="email"
                placeholder="Email Address"
                name="subscriber_email"
                value="{{ old('subscriber_email') }}"
                class="block w-full border-gray-200" >
              <button type="submit" aria-label="submit" class="absolute right-0 top-0 h-full px-3">
                <x-heroicon-o-arrow-sm-right class="w-5 h-5" />
              </button>
              @error('subscriber_email')
                <span class="text-red-500 text-sm italic">{{ $message }}</span>
              @enderror
            </form>
          @endif
        </div>
      @endforeach

      <div>
        @if($section->settings->show_payment_methods)
        <div class="mb-4">
          <h3 class="mb-1 text-sm font-semibold text-gray-800 uppercase">
            {{ __('Payment methods') }}
          </h3>
          <div>
            @foreach(\Webkul\Payment\Facades\Payment::getPaymentMethods() as $method)
              <span class="bg-gray-200 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2">
                {{ $method['method_title'] }}
              </span>
            @endforeach
          </div>
        </div>
        @endif

        @if($section->settings->show_shipping_methods)
        <div class="mb-4">
          <h3 class="mb-1 text-sm font-semibold text-gray-800 uppercase">
            {{ __('Shipping methods') }}
          </h3>
          <div>
            @foreach(\Webkul\Shipping\Facades\Shipping::getShippingMethods() as $method)
              <span class="bg-gray-200 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2">
                {{ $method['method_title'] }}
              </span>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</footer>
