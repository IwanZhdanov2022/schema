<?php

namespace Iwan07\Schema\scalar;

use Iwan07\Schema\base\AbstractScalarSchema;

class FloatSchema extends AbstractScalarSchema
{
    protected ?float $value = null;

    public function __set(string $property, ?float $value): void
    {
        if ($property === 'value') {
            $this->value = $value;
        }
    }

    public function __get(string $property): ?float
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
