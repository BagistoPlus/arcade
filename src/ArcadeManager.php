<?php

namespace EldoMagan\BagistoArcade;

use EldoMagan\BagistoArcade\Contracts\CreateCustomer;
use EldoMagan\BagistoArcade\Facades\Sections;
use EldoMagan\BagistoArcade\Sections\Section;
use EldoMagan\BagistoArcade\Sections\SectionDataCollector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

class ArcadeManager
{
    protected SectionDataCollector $sectionDataCollector;

    protected $customerRegistrationValidationRules = [];

    public function __construct(SectionDataCollector $sectionDataCollector)
    {
        $this->sectionDataCollector = $sectionDataCollector;
    }

    public function sectionDataCollector(): SectionDataCollector
    {
        return $this->sectionDataCollector;
    }

    public function collectSectionData($id, $path = null)
    {
        return $this->sectionDataCollector->collectSectionData($id, $path);
    }

    public function collectSectionGlobals($id, Collection $globals)
    {
        return $this->sectionDataCollector->collectSectionGlobals($id, $globals);
    }

    public function isSectionEnabled($sectionId)
    {
        return ! $this->sectionDataCollector()->getSectionData($sectionId)->get('section')->disabled;
    }

    public function registerSection($sectionClass, $prefix)
    {
        $section = Section::createFromComponent($sectionClass);
        $section->slug($prefix . '-' . $section->slug);

        Sections::add($section);

        if ($section->isLivewire) {
            Livewire::component('arcade-section-' . $section->slug, $sectionClass);
        } else {
            Blade::component($sectionClass, 'arcade-section-' . $section->slug);
        }
    }

    public function registerSections($sections, $prefix)
    {
        collect($sections)->each(function ($section) use ($prefix) {
            $this->registerSection($section, $prefix);
        });
    }

    public function addCustomerRegistrationValidation(array $rules)
    {
        $this->customerRegistrationValidationRules = array_merge($this->customerRegistrationValidationRules, $rules);
    }

    public function customerRegistrationValidation()
    {
        return $this->customerRegistrationValidationRules;
    }

    public function createCustomerUsing($creator)
    {
        app()->bind(CreateCustomer::class, $creator);
    }
}
