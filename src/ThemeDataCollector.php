<?php

namespace EldoMagan\BagistoArcade;

use ArrayObject;
use EldoMagan\BagistoArcade\Facades\Sections;
use EldoMagan\BagistoArcade\Facades\ThemeEditor;
use EldoMagan\BagistoArcade\Sections\Concerns\SectionData;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;
use Webkul\API\Http\Resources\Catalog\Category as CategoryResource;
use Webkul\API\Http\Resources\Catalog\Product as ProductResource;

class ThemeDataCollector
{
    protected $files;

    protected $sectionsData;

    protected $editorInitialStore = [
        'products' => [],
        'categories' => [],
    ];

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->sectionsData = collect();
    }

    public function getSectionsData()
    {
        return $this->sectionsData;
    }

    public function getSectionData($id)
    {
        return $this->sectionsData->get($id);
    }

    public function getThemeSettings()
    {
        if (ThemeEditor::active()) {
            $path = sprintf("%s/themes/%s/editor/theme.json", config('arcade.data_path'), themes()->current()->code);
        } else {
            $path = sprintf("%s/themes/%s/live/theme.json", config('arcade.data_path'), themes()->current()->code);
        }

        $data = $this->loadFileContent($path);

        return $data['settings'] ?? new ArrayObject();
    }

    public function getEditorInitialStore()
    {
        return $this->editorInitialStore;
    }

    public function collectSectionData($id, $path = null)
    {
        if (! $this->sectionsData->has($id)) {
            $this->sectionsData->put($id, collect());
        }

        if (null === $path) {
            if (ThemeEditor::active()) {
                $path = sprintf("%s/themes/%s/editor/theme.json", config('arcade.data_path'), themes()->current()->code);
            } else {
                $path = sprintf("%s/themes/%s/live/theme.json", config('arcade.data_path'), themes()->current()->code);
            }
        }


        $data = $this->collectSectionDataFromPath($id, $path);
        $data['settings'] = $data['settings'] ?? [];
        $section = Sections::get($data['type'] ?? $id);

        /**
         * Compute default settings values
         * TODO: should refactor this
         */

        if (empty($data['settings']) && isset($section->default['settings'])) {
            $data['settings'] = $section->default['settings'];
        }

        foreach ($section->settings as $setting) {
            if (! isset($data['settings'][$setting->id])) {
                $data['settings'][$setting->id] = $setting->default;
            }
        }

        if (! isset($data['blocks']) && isset($section->default['blocks'])) {
            $data['blocks'] = collect($section->default['blocks'])
                ->groupBy('type')
                ->map(function ($blocks) {
                    return $blocks->first();
                })
                ->toArray();
        }

        collect($data['blocks'] ?? [])->each(function ($blockData, $id) use ($section, &$data) {
            $blockSettings = collect($section->blocks)
                ->filter(function ($block) use ($blockData) {
                    return $block->type === $blockData['type'];
                })
                ->first()->settings ?? [];

            $data['blocks'][$id]['settings'] = $data['blocks'][$id]['settings'] ?? [];

            foreach ($blockSettings as $setting) {
                if (! isset($data['blocks'][$id]['settings'][$setting->id])) {
                    $data['blocks'][$id]['settings'][$setting->id] = $setting->default;
                }
            }
        });

        $this->sectionsData->get($id)->put('section', new SectionData($id, $data));

        if (arcadeEditor()->inDesignMode()) {
            collect($data['settings'])
                ->each(function ($value, $key) use ($section) {
                    $setting = collect($section->settings)->filter(function ($setting) use ($key) {
                        return $setting->id === $key;
                    })->first();

                    if ($setting && in_array($setting->type, ['product', 'category'])) {
                        $this->populateInitalStore($setting->type, $value);
                    }
                });

            collect($data['blocks'] ?? [])
                ->each(function ($blockData, $id) use ($section) {
                    $block = collect($section->blocks)->filter(function ($block) use ($blockData) {
                        return $block->type === $blockData['type'];
                    })->first();

                    collect($blockData['settings'])->each(function ($value, $key) use ($block) {
                        $setting = collect($block->settings)->filter(function ($setting) use ($key) {
                            return $setting->id === $key;
                        })->first();

                        if ($setting && in_array($setting->type, ['product', 'category'])) {
                            $this->populateInitalStore($setting->type, $value);
                        }
                    });
                });
        }

        return $this->sectionsData->get($id);
    }

    public function collectSectionGlobals($id, Collection $globals)
    {
        if (! $this->sectionsData->has($id)) {
            $this->sectionsData->put($id, collect());
        }

        $globals->each(function ($value, $key) use ($id) {
            $this->sectionsData->get($id)->put($key, $value);
        });
    }

    protected function collectSectionDataFromPath($id, $path)
    {
        $data = $this->loadFileContent($path);
        $sectionData = Arr::get($data, "sections.$id");

        return $sectionData ?? [];
    }

    protected function loadFileContent($path)
    {
        if (! $this->files->exists($path)) {
            return [];
        }

        if ('json' === pathinfo($path, PATHINFO_EXTENSION)) {
            return json_decode($this->files->get($path), true);
        } else {
            return Yaml::parseFile($path);
        }
    }

    protected function populateInitalStore($modelType, $modelId)
    {
        switch ($modelType) {
            case 'product':
                $model = new ProductResource(arcade_get_product($modelId));
                $this->editorInitialStore['products'][$modelId] = $model;

                break;
            case 'category':
                $model = new CategoryResource(arcade_get_category($modelId));
                $this->editorInitialStore['categories'][$modelId] = $model;

                break;
        }
    }
}
