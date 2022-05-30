@props([
  'product' => null
])

@php
  $this->setData('links', []);
@endphp

@if ($product->downloadable_samples->count())
  <div class="border-t mt-4">
    <h3 class="font-semibold text-lg">{{ __('shop::app.products.samples') }}</h3>

    <ul>
      @foreach ($product->downloadable_samples as $sample)
        <li>
          <a class="text-primary" href="{{ route('shop.downloadable.download_sample', ['type' => 'sample', 'id' => $sample->id]) }}" target="_blank">
            {{ $sample->title }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>
@endif

@if ($product->downloadable_links->count())
  <div class="border-t mt-4">
    <h3 class="font-semibold text-lg">{{ __('shop::app.products.links') }}</h3>

    <ul class="mt-2">
      @foreach ($product->downloadable_links as $link)
        <li>
          <div class="checkbox col-12 ml10">
            <label class="inline-flex items-center">
              <input name="links" type="checkbox" value="{{ $link->id }}" wire:model="data.links">
              <span class="ml-2">
                {{ $link->title . ' + ' . core()->currency($link->price) }}
              </span>
              @if ($link->sample_file || $link->sample_url)
                <a
                    target="_blank"
                    class="text-primary ml-2"
                    href="{{ route('shop.downloadable.download_sample', [
                        'type' => 'link',
                        'id' => $link->id
                    ]) }}">

                    {{ __('shop::app.products.sample') }}
                </a>
              @endif
            </label>
          </div>
        </li>
      @endforeach
    </ul>

    <span class="control-error" v-if="errors.has('links[]')" v-text="errors.first('links[]')"></span>
  </div>
@endif
