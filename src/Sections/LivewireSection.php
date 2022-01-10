<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Sections\Concerns\SectionData;
use EldoMagan\BagistoArcade\Sections\Concerns\SectionTrait;
use Livewire\Component;

class LivewireSection extends Component implements SectionInterface
{
    use SectionTrait;

    protected $context;

    protected $section;

    public function setContext($context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function setSection(SectionData $section)
    {
        $this->section = $section;
    }

    public function getSection()
    {
        return $this->section;
    }

    public function render()
    {
        return view('shop::sections.livewire');
    }
}
