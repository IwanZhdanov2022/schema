<?php

namespace Iwan07\Schema\base;

use Iwan07\Schema\interface\JsonInterface;

abstract class AbstractMixedSchema extends AbstractSchema implements JsonInterface
{
    abstract public function toArray(): array;

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}
