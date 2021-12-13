<?php

namespace EldoMagan\BagistoArcade\LivewireFeatures;

use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\Response;

final class SupportAttributes
{
    protected $attributesByComponents = [];

    public static function init()
    {
        return new static();
    }

    public function __construct()
    {
        Livewire::listen('component.dehydrate', function (Component $component, Response $response) {
            $response->memo['attributes'] = $this->attributesByComponents[$component->id] ?? [];
        });

        Livewire::listen('component.hydrate.subsequent', function ($component, $request) {
            $this->attributesByComponents[$component->id] = $request->memo['attributes'] ?? [];
        });

        Livewire::listen('component.mount', function (Component $component, $params) {
            $this->attributesByComponents[$component->id] = $params;
        });

        Livewire::listen('component.rendered', function (Component $component, View $view) {
            $attributes = new ComponentAttributeBag(
                $this->attributesByComponents[$component->id] ?? []
            );

            $view->with(['attributes' => $attributes]);
        });
    }
}
