<form>
  <div>
    <label class="block">
      <span class="font-semibold">{{ __('shop::app.checkout.onepage.enter-coupon-code') }}</span>
      <input
        type="text"
        class="mt-1 block w-full border-gray-300"
        wire:model="couponCode">
    </label>
    @error('couponCode')
      <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror
  </div>
</form>
