<div class="container py-16">
  <div class="flex space-x-6">
    <div class="flex-1">
      <div class="flex border">
        @foreach ($this->steps() as $key => $step)
          @if($step['is_active'])
            <a
              href="#"
              class="
                relative overflow-hidden flex-1 flex px-4 py-2 items-center hover:bg-gray-50
                @if($this->isStepActive($key))
                  text-primary
                @else
                  text-gray-600
                @endif
              "
              wire:click="goToStep('{{ $key }}')"
            >
              <div class="w-10 h-10 border border-current rounded-full flex-none flex items-center justify-center">
                @svg($step['icon'], ['class' => 'h-6 w-6'])
              </div>
              <span class="hidden lg:inline ml-4">
                {{ $step['text'] }}
              </span>

              @if(!$loop->last)
                <span class="absolute right-0 -top-1 border-t h-16 w-px transform -rotate-12 bg-gray-300"></span>
                <span class="absolute right-0 top-0 border-t h-16 w-px transform rotate-12 bg-gray-300"></span>
              @endif
            </a>
          @endif
        @endforeach
      </div>

      <div class="mt-4">
        @include('shop::partials.checkout.' . $this->activeStep, ['cart' => $this->cart])
      </div>

      @unless($this->isStepActive('review'))
        <div class="mt-4">
          <button class="py-3 px-6 bg-primary text-white" wire:click="submit">
            {{ __('shop::app.checkout.onepage.continue') }}
          </button>
        </div>
      @endunless
    </div>

    <div class="hidden lg:block w-96 flex-none">
      <div class="border p-4">
        <x-cart-summary />
      </div>

      @if($this->isStepActive('review'))
        <div class="mt-4 border p-4">
          <livewire:cart-apply-coupon />
        </div>
      @endif
    </div>
  </div>
</div>
