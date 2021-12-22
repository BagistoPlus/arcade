@extends('admin::layouts.content')

@section('page_title')
  Arcade - Themes
@stop

@section('content')
  <div class="content max-w-3xl mx-auto">
    <div class="page-header">
      <div class="page-title">
        <h1>Themes</h1>
      </div>
    </div>

    <div class="page-content">
      @forelse($themes as $code => $theme)
        <div class="relative px-16 min-h-[20rem] pt-12 pb-16 mb-6 bg-white shadow border border-gray-200 rounded">
          <div class="absolute inset-0 w-full h-full  bg-no-repeat bg-right" style="background-image: url({{ asset('vendor/arcade/admin/images/theme_preview.png') }})"></div>
          <div class="relative w-full max-w-xs">
            <h3 class="font-semibold text-2xl">{{ $theme['name'] }}</h3>

            <div class="space-x-4">
              <a href="{{ route('arcade.admin.themes.editor', ['theme' => $code]) }}" class="btn btn-lg btn-primary">Customize</a>
              <a href="{{ route('shop.home.index', ['previewMode' => $code]) }}" target="_blank" class="btn btn-secondary btn-lg">Preview</a>
            </div>
          </div>
        </div>
      @empty
        <div class="card">
          No themes found.
        </div>
      @endforelse
    </div>
  </div>
@stop
