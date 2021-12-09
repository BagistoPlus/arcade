<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    @include('shop::partials.head')
  </head>
  <body @if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif style="scroll-behavior: smooth;">

    <main role="main" tabindex="-1">
      @arcade_layout_content
    </main>

    @include('shop::partials.scripts')
    @yield('scripts')
  </body>
</html>
