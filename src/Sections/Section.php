<?php

namespace EldoMagan\BagistoArcade\Sections;

use artem_c\emmet\Emmet;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use JsonSerializable;
use Livewire\Component as LivewireComponent;

/**
 * @property-read string $slug
 * @property-read string $label
 * @property-read string $wrapper
 * @property-read SettingType[] $settings
 * @property-read array $blocks
 * @property-read int $maxBlocks
 * @property-read bool $isLivewire
 * @property-read string $description
 * @property-read string $previewImageUrl
 * @property-read string $previewDescription
 */
final class Section implements Arrayable, JsonSerializable
{
    /**
     * Blade/Livewire component is registered using this slug
     */
    private $slug;

    /**
     * Shown in the editor left panel
     */
    private $label;

    /**
     * An emmet formatted string of the section wrapper
     */
    private $wrapper;

    /**
     * The section settings list
     */
    private $settings;

    /**
     * List of blocks the section can accept with their configuration
     */
    private $blocks;

    /**
     * The maximum number of blocks the section can accept
     */
    private $maxBlocks;

    /**
     * Is this a livewire component ?
     */
    private $isLivewire;

    /**
     * The section description
     * Shown on the theme editor left panel when editing a section
     */
    private $description;

    /**
     * The section preview image
     * Shown on the sections selector of the theme editor
     */
    private $previewImageUrl;

    /**
     * The section preview description
     * Shown on the sections selector of the theme editor
     */
    private $previewDescription;

    public function __construct(
        $slug,
        $label,
        $wrapper,
        array $settings = [],
        array $blocks = [],
        $maxBlocks = 16,
        $description = '',
        $previewImageUrl = '',
        $previewDescription = '',
        $isLivewire = false
    ) {
        $this->slug = $slug;
        $this->label = $label;
        $this->wrapper = $wrapper;
        $this->settings = $settings;
        $this->blocks = $blocks;
        $this->maxBlocks = $maxBlocks;
        $this->description = $description;
        $this->previewImageUrl = $previewImageUrl;
        $this->previewDescription = $previewDescription;
        $this->isLivewire = $isLivewire;
    }

    /**
     * Set section slug
     *
     * @param string $slug
     * @return self
     */
    public function slug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * Generate the section blade template
     *
     * @param string $id
     * @return string
     */
    public function renderToBlade(string $id = null): string
    {
        if (! $id) {
            $id = Str::random(10);
        }

        if ($this->isLivewire) {
            $component = sprintf("@livewire('arcade-section-%s', ['arcadeId' => '%s'])", $this->slug, $id);
        } else {
            $component = sprintf('<x-arcade-section-%s arcadeId="%s" />', $this->slug, $id);
        }

        $template = (new Emmet($this->wrapper . '>{`content`}'))->create(['content' => $component]);

        $tagPosition = strpos($template, '>');

        if ($tagPosition) {
            $template = substr($template, 0, $tagPosition) . sprintf(' data-section-type="%s" data-section-id="%s"', $this->slug, $id) . substr($template, $tagPosition);

            $classPosition = strripos($template, 'class="');

            if ($classPosition) {
                $template = substr($template, 0, $classPosition + 7) . 'arcade-section ' . substr($template, $classPosition + 7);
            } else {
                $template = substr($template, 0, $tagPosition) . ' class="arcade-section"' . substr($template, $tagPosition);
            }

            return $template;
        }

        return sprintf("<div class='arcade-section' data-section-type='%s' data-section-id='%s'>%s</div>", $this->slug, $id, $component);
    }

    public function toArray()
    {
        return [
            'slug' => $this->slug,
            'label' => $this->label,
            'wrapper' => $this->wrapper,
            'settings' => $this->settings,
            'blocks' => $this->blocks,
            'maxBlocks' => $this->maxBlocks,
            'description' => $this->description,
            'previewImageUrl' => $this->previewImageUrl,
            'previewDescription' => $this->previewDescription,
            'isLivewire' => $this->isLivewire,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public static function createFromComponent($component)
    {
        return new static(
            $component::slug(),
            $component::label(),
            $component::wrapper(),
            $component::settings(),
            $component::blocks(),
            $component::maxBlocks(),
            $component::description(),
            $component::previewImageUrl(),
            $component::previewDescription(),
            is_subclass_of($component, LivewireComponent::class)
        );
    }
}
