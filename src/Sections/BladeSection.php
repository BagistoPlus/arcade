<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Sections\Concerns\SectionTrait;
use Illuminate\View\Component;

abstract class BladeSection extends Component implements SectionInterface
{
    use SectionTrait;

    private $sectionData;

    /**
     * Section data
     *
     * @var \EldoMagan\BagistoArcade\Sections\Concerns\SectionData
     */
    protected $section;

    public function __construct($arcadeId)
    {
        $this->arcadeId = $arcadeId;
        $this->sectionData = Arcade::sectionDataCollector()->getSectionData($this->arcadeId);
        $this->section = $this->sectionData->get('section');
    }

    /**
     * Get the data that should be supplied to the view.
     *
     * @author Freek Van der Herten
     * @author Brent Roose
     * @author Eldo Magan
     *
     * @return array
     */
    public function data()
    {
        $this->attributes = $this->attributes ?: $this->newAttributeBag();

        return array_merge(
            $this->extractPublicProperties(),
            $this->extractPublicMethods(),
            $this->getArcadeSectionData()
        );
    }

    /**
     * Get the methods that should be ignored.
     *
     * @return array
     */
    protected function ignoredMethods()
    {
        return array_merge([
            'data',
            'render',
            'resolveView',
            'shouldRender',
            'view',
            'withName',
            'withAttributes',
            'slug',
            'label',
            'wrapper',
            'settings',
            'blocks',
            'maxBlocks',
            'description',
            'previewImageUrl',
            'previewDescription',
        ], $this->except);
    }

    protected function getArcadeSectionData()
    {
        return $this->sectionData->all();
    }
}
