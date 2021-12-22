<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if ($favicon = core()->getConfigData('general.design.admin_logo.favicon', core()->getCurrentChannelCode()))
      <link rel="icon" sizes="16x16" href="{{ \Illuminate\Support\Facades\Storage::url($favicon) }}" />
    @else
      <link rel="icon" sizes="16x16" href="{{ asset('vendor/webkul/ui/assets/images/favicon.ico') }}" />
    @endif

    <link rel="stylesheet" href="{{ asset('vendor/arcade/theme-editor/style.css') }}">
  </head>

  <body @if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif style="scroll-behavior: smooth;">
    <script type="text/javascript">
      const Arcade = {
        theme: {
          code: "{{ $theme['code'] }}",
          name: "{{ $theme['name'] }}",
          storefrontUrl: "{{ $storefrontUrl }}",
        },
        themesIndex: "{{ route('arcade.admin.themes.index') }}",
      }
    </script>

    <div id="app"></div>

    <script type="text/javascript" src="{{ asset('vendor/arcade/theme-editor/app.js') }}"></script>
  </body>
</html>
