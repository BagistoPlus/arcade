<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class SettingValues implements Arrayable, JsonSerializable
{
    protected $settings;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public function __get($name)
    {
        return $this->settings[$name] ?? null;
    }

    public function toArray()
    {
        return $this->settings;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
