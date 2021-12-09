<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use Illuminate\Support\Str;

trait SectionTrait
{
    protected static $slug;
    protected static $label;
    protected static $wrapper;
    protected static $settings;
    protected static $blocks;
    protected static $maxBlocks;
    protected static $description;
    protected static $previewImageUrl;
    protected static $previewDescription;

    /**
     * Section unique id used to retrive it's data
     */
    public $arcadeId;

    protected static function className()
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }

    public static function slug()
    {
        if (static::$slug) {
            return static::$slug;
        }

        return Str::kebab(self::className());
    }

    public static function label()
    {
        if (static::$label) {
            return static::$label;
        }

        return Str::of(self::slug())->replace('-', ' ')->title();
    }

    public static function wrapper()
    {
        if (static::$wrapper) {
            return static::$wrapper;
        }

        return 'section';
    }

    public static function settings()
    {
        if (static::$settings) {
            return static::$settings;
        }

        return [];
    }

    public static function blocks()
    {
        if (static::$blocks) {
            return static::$blocks;
        }

        return [];
    }

    public static function maxBlocks()
    {
        if (static::$maxBlocks) {
            return static::$maxBlocks;
        }

        return 16;
    }

    public static function description()
    {
        if (static::$description) {
            return static::$description;
        }

        return '';
    }

    public static function previewImageUrl()
    {
        if (static::$previewImageUrl) {
            return static::$previewImageUrl;
        }

        return '';
    }

    public static function previewDescription()
    {
        if (static::$previewDescription) {
            return static::$previewDescription;
        }

        return '';
    }
}
