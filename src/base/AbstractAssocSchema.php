<?php

namespace Iwan07\Schema\base;

use Iwan07\Schema\interface\JsonInterface;

abstract class AbstractAssocSchema extends AbstractMixedSchema
{
    protected array $data = [];

    abstract protected function getTypeClass(): string;

    public function __get(string $key): mixed
    {
        return $this->get($key);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            $this->data[$key] = new ($this->getTypeClass());
        }
        if (
            $this->data[$key] instanceof AbstractScalarSchema
            || $this->data[$key] instanceof AbstractEnumSchema
        ) {
            return $this->data[$key]->value;
        }
        return $this->data[$key];
    }

    public function set(string $key, mixed $value): static
    {
        if (!($value instanceof AbstractSchema)) {
            $obj = new ($this->getTypeClass());
            if ($obj instanceof JsonInterface) {
                $value = ($this->getTypeClass())::restore($value);
            }
            if ($obj instanceof AbstractScalarSchema) {
                $obj->value = $value;
                $value = $obj;
            }
        }
        if (!($value instanceof ($this->getTypeClass()))) {
            throw new \Exception('Incorrect type. Must be instance of ' . $this->getTypeClass());
        }
        $this->data[$key] = $value;
        return $this;
    }

    public function delete(string $key): static
    {
        unset($this->data[$key]);
        return $this;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->data as $key => $obj) {
            $result[$key] = $obj->toArray();
        }
        return $result;
    }

    public static function restore(array $data): static
    {
        $obj = new static;
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $obj[$key] = ($obj->getTypeClass())::restore($value);
            } else {
                $obj[$key] = $value;
            }
        }
        return $obj;
    }

    public function validate(): array
    {
        $result = [];
        foreach ($this->data as $key => $item) {
            $errors = $item->validate();
            if (!empty($errors)) {
                $result[$key] = $errors;
            }
        }
        return $result;
    }
}
