<?php

namespace EldoMagan\BagistoArcade\LivewireFeatures;

use DateTimeInterface;
use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Sections\Concerns\SectionData;
use EldoMagan\BagistoArcade\Sections\LivewireSection;
use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Contracts\Queue\QueueableCollection;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesAndRestoresModelIdentifiers;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\Response;

class SupportSectionData
{
    use SerializesAndRestoresModelIdentifiers;

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

            $response->memo['arcadeData'] = [];
            $response->memo['arcadeDataMeta'] = [];

            foreach ($component->getContext() as $key => $value) {
                if (is_scalar($value) || is_null($value) || is_array($value) || $key === 'section') {
                    data_set($response, 'memo.arcadeData.'.$key, $value);
                } elseif ($value instanceof QueueableEntity) {
                    static::dehydrateModel($value, $key, $response);
                }
            }
        });

        Livewire::listen('component.hydrate.subsequent', function ($component, $request) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $data = $request->memo['arcadeData'] ?? [];
            $context = [];

            $models = data_get($request, 'memo.arcadeDataMeta.models', []);

            foreach ($data as $key => $value) {
                if ('section' === $key) {
                    $context[$key] = new SectionData($component->arcadeId, $value);
                } elseif ($serialized = data_get($models, $key)) {
                    $context[$key] = static::hydrateModel($serialized, $key, $request);
                } else {
                    $context[$key] = $value;
                }
            }

            $component->setContext($context);
            $component->setSection($context['section']);
        });

        Livewire::listen('component.mount', function (Component $component, $params) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $data = Arcade::sectionDataCollector()
                ->getSectionData($component->arcadeId)
                ->filter(function ($value) {
                    return is_scalar($value)
                        || is_array($value)
                        || is_null($value)
                        || $value instanceof SectionData
                        || $value instanceof QueueableEntity
                        || $value instanceof QueueableCollection
                        || $value instanceof Collection
                        || $value instanceof DateTimeInterface
                        || $value instanceof Stringable;
                })
                ->all();

            $component->setContext($data);
            $component->setSection($data['section']);
        });

        Livewire::listen('component.rendered', function (Component $component, View $view) {
            if (! ($component instanceof LivewireSection)) {
                return;
            }

            $view->with($component->getContext());
        });
    }

    protected static function dehydrateModel($value, $key, $response)
    {
        $serializedModel = $value instanceof QueueableEntity && ! $value->exists
            ? ['class' => get_class($value)]
            : (array) (new static())->getSerializedPropertyValue($value);

        // Deserialize the models into the "meta" bag.
        data_set($response, 'memo.arcadeDataMeta.models.'.$key, $serializedModel);

        data_set($response, 'memo.arcadeData.'.$key, $value->toArray());
    }

    protected static function hydrateModel($serialized, $key, $request)
    {
        if (isset($serialized['id'])) {
            $model = (new static())->getRestoredPropertyValue(
                new ModelIdentifier($serialized['class'], $serialized['id'], $serialized['relations'], $serialized['connection'])
            );
        } else {
            $model = new $serialized['class']();
        }

        $dirtyModelData = $request->memo['arcadeData'][$key];

        static::setDirtyData($model, $dirtyModelData);

        return $model;
    }

    public static function setDirtyData($model, $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $existingData = data_get($model, $key);

                if (is_array($existingData)) {
                    $updatedData = static::setDirtyData([], data_get($data, $key));
                } else {
                    $updatedData = static::setDirtyData($existingData, data_get($data, $key));
                }
            } else {
                $updatedData = data_get($data, $key);

                if (array_key_exists($key, $model->getRelations())) {
                    $updatedData = collect($updatedData);
                }
            }


            if ($model instanceof Model && $model->relationLoaded($key)) {
                $model->setRelation($key, $updatedData);
            } else {
                data_set($model, $key, $updatedData);
            }
        }

        return $model;
    }
}
