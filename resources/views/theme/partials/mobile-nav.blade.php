<div class="border-b px-4 py-3 bg-gray-50">
  @guest('customer')
    <p class="text-lg font-medium">{{ __('Welcome guest') }}</p>
    <div class="space-x-4 mt-2">
      <a href="{{ route('customer.session.index') }}" class="text-base">
        {{ __('shop::app.header.sign-in') }}
      </a>

      <a href="{{ route('customer.register.index') }}" class="text-base">
        {{ __('shop::app.header.sign-up') }}
      </a>
    </div>
  @else
    <p class="text-lg font-semibold">
      Hello, {{ auth()->guard('customer')->user()->first_name }}
    </p>
  @endif
</div>
<nav class="border-b">
  @foreach($categories as $category)
    <a href="{{ url()->to($category->translations[0]->url_path) }}" class="flex items-center px-4 py-3 font-medium border-b-2 border-transparent hover:border-black">
      {{ $category->name }}
    </a>
  @endforeach
</nav>
