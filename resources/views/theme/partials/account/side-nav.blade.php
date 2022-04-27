@php
  $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;
@endphp

@foreach ($menu->items as $menuItem)
  @if (! $showCompare)
    @php
      unset($menuItem['children']['compare']);
    @endphp
  @endif

  @if(!isset($menuItem['gate']) || auth('customer')->user()->can($menuItem['gate']))
    <div class="p-4 mb-4 bg-white border">
      <h3 class="text-lg font-medium">{{ trans($menuItem['name']) }}</h3>

      <ul class="mt-2 -ml-px">
        @foreach ($menuItem['children'] as $subMenuItem)
          <li>
            <a
              href="{{ $subMenuItem['url'] }}"
              class="
                flex items-center py-2
                align-text-bottom
                cursor-pointer hover:text-secondary
                @if($menu->getActive($subMenuItem))
                  font-semibold
                @endif
              "
            >
              @svg($subMenuItem['icon'] ?? 'ic-' . array_slice(explode('.', $subMenuItem['key']), -1)[0], ['class' => 'w-5 h-5 inline'])
              <span class="ml-2">
                {{ trans($subMenuItem['name']) }}
              </span>
            </a>
        </li>
        @endforeach
      </ul>
    </div>
  @endif
@endforeach
