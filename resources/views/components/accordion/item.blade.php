@props([
  'title' => 'Accordion'
])

<div x-data="{
  id: null,

  get expanded() {
    return this.active === this.id;
  },

  toggle() {
    this.active = this.expanded ? null : this.id;
  },

  init() {
    this.id = Array.from(this.$el.parentElement.children).findIndex(el => el === this.$el);
  }
}" role="region" {{ $attributes->merge(['class' => 'border']) }}>
  @if(isset($trigger))
    {{ $trigger }}
  @else
    <button
      x-on:click="toggle"
      x-bind:aria-expanded="expanded"
      type="button"
      class="flex items-center justify-between w-full font-bold text-lg px-6 py-3"
    >
      <span>{{ $title }}</span>
      <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
      <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
    </button>
  @endif

  <div x-cloak x-show="expanded" x-collapse>
    {{ $slot }}
  </div>
</div>
