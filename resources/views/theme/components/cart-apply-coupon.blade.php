<form {{ $attributes }} wire:submit.prevent="submit">
  @if (session()->has('message'))
    <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
      {{ session('message') }}
    </div>
  @endif

  <div>
    <input
      type="text"
      wire:model="code"
      class="border-gray-300 mt-1 block w-full"
      placeholder="{{ __('shop::app.checkout.onepage.enter-coupon-code') }}"
    >
    @error('code')
      <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
  </div>

  <button
    type="submit"
    class="relative block w-full mt-2 py-2 bg-black text-white"
    wire:loading.class="text-transparent relative pointer-events-none"
    wire:target="submit"
  >
    {{ __('shop::app.checkout.onepage.apply-coupon') }}
    <div wire:loading wire:target="submit" class="text-white absolute left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2">
      <div class="w-4 h-4 rounded-full border-2 border-current border-r-transparent animate animate-spin"></div>
    </div>
  </button>
</form>
