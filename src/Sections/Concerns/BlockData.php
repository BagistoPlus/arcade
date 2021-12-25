<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property-read string $id
 * @property-read string $type
 * @property-read SettingValues $settings
 */
class BlockData implements Arrayable, JsonSerializable
{
    protected string $id;
    protected string $type;
    protected bool $disabled;
    protected SettingValues $settings;

    public function __construct(string $id, array $data)
    {
        $this->id = $id;
        $this->type = $data['type'] ?? $id;
        $this->disabled = $data['disabled'] ?? false;
        $this->settings = new SettingValues($data['settings'] ?? []);
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'disabled' => $this->disabled,
            'settings' => $this->settings->toArray(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
