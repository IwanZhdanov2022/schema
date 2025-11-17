<?php

namespace Iwan07\Schema\scalar;

use Iwan07\Schema\base\AbstractScalarSchema;

class BoolSchema extends AbstractScalarSchema
{
    protected ?bool $value = null;

    public function __set(string $property, ?bool $value): void
    {
        if ($property === 'value') {
            $this->value = $value;
        }
    }

    public function __get(string $property): ?bool
    {
        if ($property === 'value') {
            return $this->value;
        }
        return null;
    }

    public function __toString()
    {
        return is_null($this->value) ? "" : ($this->value ? "Y" : "N");
    }
}
