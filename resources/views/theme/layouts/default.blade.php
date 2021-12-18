@php
  $direction = 'ltr';
  if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction === 'rtl') {
    $direction = 'rtl';
  }
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    @include('shop::partials.head')
  </head>
  <body class="{{ $direction }} bg-default text-on-default" style="scroll-behavior: smooth;">

    <arcade:section name="arcade-announcement-bar" />
    <arcade:section name="arcade-header" />

    <main role="main" tabindex="-1">
      @arcade_layout_content
      {{-- <arcade:layout-content />
      <arcade:slot name=""/> --}}
    </main>

    @include('shop::partials.scripts')
    @yield('scripts')
  </body>
</html>
