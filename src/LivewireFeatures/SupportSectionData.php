<?php

namespace EldoMagan\BagistoArcade\LivewireFeatures;

use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Sections\Concerns\SectionData;
use EldoMagan\BagistoArcade\Sections\LivewireSection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\Response;

class SupportSectionData
{
    protected $arcadeDataByComponents = [];

    public static function init()
    {
        return new static();
    }

    final public function __construct()
    {
        Livewire::listen('component.dehydrate', function (Component $component, Response $response) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $response->memo['arcadeData'] = $this->arcadeDataByComponents[$component->id] ?? [];
        });

        Livewire::listen('component.hydrate.subsequent', function ($component, $request) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $this->arcadeDataByComponents[$component->id] = $request->memo['arcadeData'] ?? [];
        });

        Livewire::listen('component.mount', function (Component $component, $params) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $data = Arcade::sectionDataCollector()
                ->getSectionData($component->arcadeId)
                ->except(['errors'])
                ->toArray();

            $this->arcadeDataByComponents[$component->id] = $data;
        });

        Livewire::listen('component.rendered', function (Component $component, View $view) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $data = $this->arcadeDataByComponents[$component->id] ?? [];

            if (isset($data['section'])) {
                $data['section'] = new SectionData($component->arcadeId, $data['section']);
            }

            $view->with($data);
        });
    }
}
