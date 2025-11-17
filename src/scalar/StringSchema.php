<?php

namespace Iwan07\Schema\scalar;

use Iwan07\Schema\base\AbstractScalarSchema;

class StringSchema extends AbstractScalarSchema
{
    protected ?string $value = null;

    public function __set(string $property, ?string $value): void
    {
        if ($property === 'value') {
            $this->value = $value;
        }
    }

    public function __get(string $property): ?string
    {
        if ($property === 'value') {
            return $this->value;
        }
        return null;
    }

    public function __toString()
    {
        return is_null($this->value) ?  "" : (string)$this->value;
    }
}
