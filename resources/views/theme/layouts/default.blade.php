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
  <body class="{{ $direction }} bg-background text-on-background" style="scroll-behavior: smooth;">

    <arcade:section name="arcade-announcement-bar" />
    <arcade:section name="arcade-header" />

    <main role="main" tabindex="-1">
      @section('body')
        @arcade_layout_content
      @show
    </main>

    <arcade:section name="arcade-footer" />

    @arcade_slot('bagisto.shop.layout.body.after')

    @include('shop::partials.scripts')
  </body>
</html>
