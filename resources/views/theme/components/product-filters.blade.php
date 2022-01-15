<div>
  @foreach($filters as $filter)
    <x-arcade::accordion class="mb-4" :defaultOpen="$loop->first ? '0' : 'null'">
      <x-arcade::accordion.item :title="$filter->name">
        @if($filter->type === 'price')
          <div class="px-6 py-4">
            @if($attributes->has('wire'))
              <x-arcade::range-input
                min="0"
                max="100000"
                step="500"
                wire:model="filters.price"
              />
            @else
              <x-arcade::range-input
                min="0"
                max="100000"
                step="500"
              />
            @endif
          </div>
        @else
          <div class="px-6 py-4 space-y-2">
            @foreach($filter->options as $option)
              <label class="flex items-center">
                <input type="checkbox" name="{{ $filter->code }}" value="{{ $option->id }}" @if($attributes->has('wire')) wire:model="filters.{{ $filter->code }}" @endif>
                <span class="ml-2">{{ $option->label ?? $option->admin_name }}</span>
              </label>
            @endforeach
          </div>
        @endif
      </x-arcade::accordion.item>
    </x-arcade::accordion.item>
  @endforeach
</div>
