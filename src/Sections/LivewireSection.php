<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Sections\Concerns\SectionTrait;
use Livewire\Component;

class LivewireSection extends Component implements SectionInterface
{
    use SectionTrait;

    public function render()
    {
        return view('shop::sections.livewire');
    }
}
