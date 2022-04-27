<div class="container py-10">
  <div class="md:flex md:space-x-10">
    <div class="flex-none md:w-72 xl:80">
      @include('shop::partials.account.side-nav')
    </div>

    <div class="flex-1">
      <div class="bg-white border ">
        <div class="flex items-center justify-between px-4 py-4 border-b border-gray-300">
          <h1 class="text-2xl font-semibold">{{ $title }}</h1>
          @isset($actions)
            <div>
              {{ $actions }}
            </div>
          @endisset
        </div>
        <div class="p-4">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>
</div>
