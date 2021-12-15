<div
  x-cloak
  x-show="opened"
  role="menu"
  x-transition:enter="transition ease-out duration-100 origin-top"
  x-transition:leave="transition ease-in duration-100 origin-top"
  x-transition:enter-start="opacity-0 transform scale-90"
  x-transition:enter-end="opacity-100 transform scale-100"
  x-transition:leave-start="opacity-100 transform scale-100"
  x-transition:leave-end="opacity-0 transform scale-90"
  {{ $attributes->merge(['class' => 'absolute']) }}>
  {{ $slot ?? '' }}
</div>
