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
    --color-bg-primary: #6750A4;
    --color-on-primary: #FFFFFF;
    --color-bg-primary-container: #EADDFF;
    --color-on-primary-container: ##21005D;

    --color-bg-secondary: #625B71;
    --color-on-secondary: #FFFFFF;
    --color-bg-secondary-container: #E8DEF8;
    --color-on-secondary-container: #1D192B;

    --color-bg-accent: #7D5260;
    --color-on-accent: #FFFFFF;
    --color-bg-accent-container: #FFD8E4;
    --color-on-accent-container: #31111D;

    --color-bg-default: #FFFBFE;
    --color-on-default: #1C1B1F;

    --color-bg-surface: #FFFBFE;
    --color-on-surface: #1C1B1F;

    --color-bg-surface-variant: #E7E0EC;
    --color-on-surface-variant: #49454F;
  }

  /** dark theme */
  @media (prefers-color-scheme: dark) {
    :roo {
      --color-bg-primary: #D0BCFF;
      --color-on-primary: #381E72;
      --color-bg-primary-container: #4F378B;
      --color-on-primary-container: #EADDFF;

      --color-bg-secondary: #CCC2DC;
      --color-on-secondary: #332D41;
      --color-bg-secondary-container: #4A4458;
      --color-on-secondary-container: #E8DEF8;

      --color-bg-accent: #EFB8C8;
      --color-on-accent: #492532;
      --color-bg-accent-container: #633B48;
      --color-on-accent-container: #FFD8E4;

      --color-bg-default: #1C1B1F;
      --color-on-default: #E6E1E5;

      --color-bg-surface: #49454F;
      --color-on-surface: #E6E1E5;

      --color-bg-surface-variant: #938F99;
      --color-on-surface-variant: #CAC4D0;
    }
  }

  .dark, [dark], [data-theme="dark"] {
    --color-bg-primary: #D0BCFF;
    --color-on-primary: #381E72;
    --color-bg-primary-container: #4F378B;
    --color-on-primary-container: #EADDFF;

    --color-bg-secondary: #CCC2DC;
    --color-on-secondary: #332D41;
    --color-bg-secondary-container: #4A4458;
    --color-on-secondary-container: #E8DEF8;

    --color-bg-accent: #EFB8C8;
    --color-on-accent: #492532;
    --color-bg-accent-container: #633B48;
    --color-on-accent-container: #FFD8E4;

    --color-bg-default: #1C1B1F;
    --color-on-default: #E6E1E5;

    --color-bg-surface: #49454F;
    --color-on-surface: #E6E1E5;

    --color-bg-surface-variant: #938F99;
    --color-on-surface-variant: #CAC4D0;
  }
</style>
<link rel="stylesheet" href="{{ asset('vendor/arcade/theme.css') }}">
@stack('css')

@livewireStyles

@arcade_slot('bagisto.shop.layout.head')
