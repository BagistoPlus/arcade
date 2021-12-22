<style type="text/css">
  #section-overlay {
    border: 2px solid #0041ff;
    position: absolute;
    width: 0;
    height: 0;
    display: none;
    pointer-events: none;
    text-align: center;
    padding-top: 4px;
  }

  #section-overlay .btn {
    position: relative;
    pointer-events: auto;
    background-color: #0041ff;
    color: #fff;
    padding: 4px;
    border-radius: 4px;
  }

  #section-overlay .btn svg {
    width: 20px;
  }
</style>

<div id="section-overlay">
  <button id="move-down" class="btn"><x-heroicon-o-arrow-down /></button>
  <button id="move-up" class="btn" style="margin-right: 8px;"><x-heroicon-o-arrow-up /></button>
  <button id="edit" class="btn"><x-heroicon-o-pencil-alt /></button>
  <button id="disable" class="btn" style="margin-right: 8px;"><x-heroicon-o-eye-off /></button>
  <button id="remove" class="btn"><x-heroicon-o-trash /></button>
</div>

<script type="text/javascript">
  window.themeData = @json($themeData);
  window.availableSections = @json($sections);

  if (window.Livewire) {
    window.Livewire.addHeaders({
      "X-ARCADE-EDITOR-THEME": "{{ $theme }}",
    });
  }
</script>

<script type="text/javascript" src="{{ asset('vendor/arcade/theme-editor/injected.js') }}"></script>
