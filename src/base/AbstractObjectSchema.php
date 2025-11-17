<?php

namespace Iwan07\Schema\base;

use Iwan07\Schema\interface\JsonInterface;

abstract class AbstractObjectSchema extends AbstractMixedSchema implements JsonInterface
{
    private ?array $propList = null;

    public function __construct()
    {
        $this->createFields();
        $this->fillDefaults();
    }

    public function __set(string $property, $value): void
    {
        if (!array_key_exists($property, $this->getProperties())) {
            return;
        }
        if (
            $this->$property instanceof AbstractScalarSchema
            || $this->$property instanceof AbstractEnumSchema
        ) {
            $this->$property->value = $value;
        } elseif (is_array($value)) {
            $this->$property = $this->$property::restore($value);
        } else {
            $this->$property = $value;
        }
    }

    public function __get(string $property)
    {
        if (!property_exists($this, $property)) {
            return null;
        }
        if (
            $this->$property instanceof AbstractScalarSchema
            || $this->$property instanceof AbstractEnumSchema
        ) {
            return $this->$property->value;
        } else {
            return $this->$property;
        }
    }

    public function toArray(): array
    {
        $result = [];
        foreach (array_keys($this->getProperties()) as $prop) {
            if ($this->$prop instanceof JsonInterface) {
                $result[$prop] = $this->$prop->toArray();
            } else {
                $result[$prop] = $this->$prop->value;
            }
        }
        return $result;
    }

    public static function restore(array $data): static
    {
        $obj = new static;
        foreach ($obj->getProperties() as $prop => $type) {
            if (!array_key_exists($prop, $data)) {
                continue;
            }
            $source = $data[$prop];
            if ($source instanceof JsonInterface) {
                $source = $source->toArray();
            } elseif ($source instanceof AbstractScalarSchema) {
                $source = $source->value;
            }
            $value = new $type;
            if ($value instanceof JsonInterface) {
                $value = $type::restore($source);
            } else {
                $value->value = $source;
            }
            $obj->$prop = $value;
        }
        return $obj;
    }

    public function validate(): array
    {
        $result = [];
        foreach (array_keys($this->getProperties()) as $prop) {
            $errors = $this->$prop->validate();
            if (!empty($errors)) {
                $result[$prop] = $errors;
            }
        }
        return $result;
    }

    protected function getProperties(): array
    {
        if (is_null($this->propList)) {
            $result = [];
            $reflection = new \ReflectionClass($this);
            $props = $reflection->getProperties();
            foreach ($props as $prop) {
                $result[$prop->name] = $prop->getType()->getName();
            }
            $this->propList = $result;
        }
        return $this->propList;
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function createFields(): void
    {
        foreach ($this->getProperties() as $prop => $type) {
            $this->$prop = new $type;
        }
    }

    protected function fillDefaults(): void
    {
        foreach ($this->defaults() as $prop => $default) {
            $this->$prop->value = $default;
        }
    }
}
