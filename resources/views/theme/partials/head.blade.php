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

<link rel="stylesheet" href="{{ asset('vendor/arcade/theme.css') }}">
@stack('css')

@livewireStyles

@arcade_slot('bagisto.shop.layout.head')
