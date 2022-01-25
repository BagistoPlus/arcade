<h2 class="text-2xl font-bold leading-tight">
  {{ __('shop::app.checkout.onepage.payment-methods') }}
</h2>

<div>
  @foreach ($this->paymentMethods as $payment)
    <div class="mt-4">
      <label for="{{ $payment['method'] }}" class="flex items-start">
        <input
          type="radio"
          id="{{ $payment['method'] }}"
          name="payment_method"
          value="{{ $payment['method'] }}"
          wire:model="selectedPaymentMethod"
        />
        <div class="ml-2 -mt-1">
          <h3 class="font-semibold">{{ $payment['method_title'] }}</h3>

          <p class="text-gray-600">
            {{ __($payment['description']) }}
          </p>
        </div>
      </label>
    </div>
  @endforeach

  @error('selectedPaymentMethod')
    <div class="mt-4 text-base text-red-500">{{ $message }}</div>
  @enderror
</div>
