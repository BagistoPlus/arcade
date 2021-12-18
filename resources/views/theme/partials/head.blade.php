<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="content-language" content="{{ app()->getLocale() }}">

<title>@yield('page_title')</title>

@if ($favicon = core()->getCurrentChannel()->favicon_url)
    <link rel="icon" sizes="16x16" href="{{ $favicon }}" />
@else
    <link rel="icon" sizes="16x16" href="{{ bagisto_asset('images/favicon.ico') }}" />
@endif

@stack('head')

<style>
  :root {
    /** light theme */
    --color-bg-primary: 103,80,164;
    --color-on-primary: 255,255,255;
    --color-bg-primary-container: 234,221,255;
    --color-on-primary-container: 33,0,93;

    --color-bg-secondary: 98,91,113;
    --color-on-secondary: 255,255,255;
    --color-bg-secondary-container: 232,222,248;
    --color-on-secondary-container: 29,25,43;

    --color-bg-accent: 125,82,96;
    --color-on-accent: 255,255,255;
    --color-bg-accent-container: 255,216,228;
    --color-on-accent-container: 49,17,29;

    --color-bg-default: 255,251,254;
    --color-on-default: 28,27,31;

    --color-bg-surface: 255,251,254;
    --color-on-surface: 28,27,31;

    --color-bg-surface-variant: 231,224,236;
    --color-on-surface-variant: 73,69,79;
  }

  /** dark theme */
  @media (prefers-color-scheme: dark) {
    :roo {
      --color-bg-primary: 208,188,255;
      --color-on-primary: 56,30,114;
      --color-bg-primary-container: 79,55,139;
      --color-on-primary-container: 234,221,255;

      --color-bg-secondary: 204,194,220;
      --color-on-secondary: 51,45,65;
      --color-bg-secondary-container: 74,68,88;
      --color-on-secondary-container: 232,222,248;

      --color-bg-accent: 239,184,200;
      --color-on-accent: 73,37,50;
      --color-bg-accent-container: 99,59,72;
      --color-on-accent-container: 255,216,228;

      --color-bg-default: 28,27,31;
      --color-on-default: 230,225,229;

      --color-bg-surface: 73,69,79;
      --color-on-surface: 230,225,229;

      --color-bg-surface-variant: 147,143,153;
      --color-on-surface-variant: 202,196,208;
    }
  }

  .dark, [dark], [data-theme="dark"] {
    --color-bg-primary: 208,188,255;
    --color-on-primary: 56,30,114;
    --color-bg-primary-container: 79,55,139;
    --color-on-primary-container: 234,221,255;

    --color-bg-secondary: 204,194,220;
    --color-on-secondary: 51,45,65;
    --color-bg-secondary-container: 74,68,88;
    --color-on-secondary-container: 232,222,248;

    --color-bg-accent: 239,184,200;
    --color-on-accent: 73,37,50;
    --color-bg-accent-container: 99,59,72;
    --color-on-accent-container: 255,216,228;

    --color-bg-default: 28,27,31;
    --color-on-default: 230,225,229;

    --color-bg-surface: 73,69,79;
    --color-on-surface: 230,225,229;

    --color-bg-surface-variant: 147,143,153;
    --color-on-surface-variant: 202,196,208;
  }
</style>
<link rel="stylesheet" href="{{ asset('vendor/arcade/theme.css') }}">
@stack('css')

@livewireStyles

@arcade_slot('bagisto.shop.layout.head')
