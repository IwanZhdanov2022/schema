<?php

namespace Iwan07\Schema\base;

abstract class AbstractSchema
{
    public function validate(): array
    {
        return [];
    }

    public final function isValid(): bool
    {
        return empty($this->validate());
    }
}
