<?php

namespace EldoMagan\BagistoArcade\Sections;

use Illuminate\Support\Str;

/**
 * @property-read string $type
 * @property-read string $name
 * @property-read SettingType[] $settings
 *
 * @method $this type(string $type)
 * @method $this name(string $name)
 * @method $this limit(int $limit)
 * @method $this settings(SettingType[] $settings)
 */
class Block
{
    protected string $type;
    protected string $name;
    protected int $limit = 16;
    protected array $settings;

    public function __construct(string $type, string $name = '', array $settings = [])
    {
        $this->type = $type;
        $this->name = $name ?: Str::title(Str::snake($type));
        $this->settings = $settings;
    }

    public static function make(string $type, string $name = '', array $settings = []): self
    {
        return new self($type, $name, $settings);
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function __call($name, $arguments): self
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $arguments[0];
        }

        return $this;
    }
}
