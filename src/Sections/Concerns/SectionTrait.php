<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use Illuminate\Support\Str;

trait SectionTrait
{
    protected static string $slug = '';
    protected static string $label = '';
    protected static string $wrapper = '<div>{section_content}</div>';
    protected static array $settings = [];
    protected static array $blocks = [];
    protected static int $maxBlocks = 16;
    protected static string $description = '';
    protected static string $previewImageUrl = '';
    protected static string $previewDescription = '';
    protected static array $default = [];

    protected static string $view = '';

    /**
     * Section unique id used to retrive it's data
     */
    public $arcadeId;

    protected function getViewData(): array
    {
        return [];
    }

    public function render()
    {
        return view(static::$view, $this->getViewData());
    }

    protected static function className(): string
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }

    public static function slug(): string
    {
        if (! empty(static::$slug)) {
            return static::$slug;
        }

        return Str::kebab(self::className());
    }

    public static function label(): string
    {
        if (! empty(static::$label)) {
            return static::$label;
        }

        return Str::of(self::slug())->replace('-', ' ')->title();
    }

    public static function wrapper(): string
    {
        if (! empty(static::$wrapper)) {
            return static::$wrapper;
        }

        return '<div>{section_content}</div>';
    }

    public static function settings(): array
    {
        return static::$settings;
    }

    public static function blocks(): array
    {
        return static::$blocks;
    }

    public static function maxBlocks(): int
    {
        return static::$maxBlocks;
    }

    public static function description(): string
    {
        return static::$description;
    }

    public static function previewImageUrl(): string
    {
        return static::$previewImageUrl;
    }

    public static function previewDescription(): string
    {
        return static::$previewDescription;
    }

    public static function default(): array
    {
        return static::$default;
    }
}
