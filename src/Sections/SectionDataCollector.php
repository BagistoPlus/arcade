<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Facades\Sections;
use EldoMagan\BagistoArcade\Sections\Concerns\SectionData;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class SectionDataCollector
{
    protected $files;

    protected $sectionsData;

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

    public function collectSectionData($id, $path = null)
    {
        if (! $this->sectionsData->has($id)) {
            $this->sectionsData->put($id, collect());
        }

        $data = [
            'type' => $id,
        ];

        if (null !== $path) {
            $data = $this->collectSectionDataFromPath($id, $path);
        }

        $data['settings'] = $data['settings'] ?? [];
        $section = Sections::get($data['type'] ?? $id);

        /**
         * Compute default settings values
         * TODO: should refactor this
         */
        foreach ($section->settings as $setting) {
            if (! isset($data['settings'][$setting->id])) {
                $data['settings'][$setting->id] = $setting->default;
            }
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
}
