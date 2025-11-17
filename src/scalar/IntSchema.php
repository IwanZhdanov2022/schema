<?php

namespace Iwan07\Schema\scalar;

use Iwan07\Schema\base\AbstractScalarSchema;

class IntSchema extends AbstractScalarSchema
{
    protected ?int $value = null;

    public function __set(string $property, ?int $value): void
    {
        if ($property === 'value') {
            $this->value = $value;
        }
    }

    public function __get(string $property): ?int
    {
        if ($property === 'value') {
            return $this->value;
        }
        return null;
    }

    public function __toString()
    {
        return is_null($this->value) ? "" : (string)$this->value;
    }
}
