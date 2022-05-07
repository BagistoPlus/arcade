<div class="py-10">
  <div class="container">
    <div class="prose">
      {!! DbView::make($page)->field('html_content')->render() !!}
    </div>
  </div>
</div>
