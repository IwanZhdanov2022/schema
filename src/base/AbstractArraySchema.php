<?php

namespace Iwan07\Schema\base;

use Iwan07\Schema\interface\JsonInterface;

abstract class AbstractArraySchema extends AbstractMixedSchema implements \Iterator, \ArrayAccess, \Countable, JsonInterface
{
    protected array $data = [];
    protected int $ptr = 0;

    abstract protected function getTypeClass(): string;

    public function key(): int
    {
        return $this->ptr;
    }

    public function current(): AbstractSchema
    {
        return $this->data[$this->key()];
    }

    public function rewind(): void
    {
        $this->ptr = 0;
    }

    public function next(): void
    {
        $this->ptr++;
    }

    public function valid(): bool
    {
        return $this->ptr < count($this->data);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if ($offset >= count($this->data)) {
            $this->data[$offset] = new ($this->getTypeClass());
        }
        if (
            $this->data[$offset] instanceof AbstractScalarSchema
            || $this->data[$offset] instanceof AbstractEnumSchema
        ) {
            return $this->data[$offset]->value;
        }
        return $this->data[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
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
        if (is_null($offset)) {
            $offset = count($this->data);
        }
        for ($a = count($this->data); $a < $offset; $a++) {
            $this->data[$a] = new ($value::class);
        }
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
        $this->data = array_values($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this as $value) {
            if ($value instanceof JsonInterface) {
                $result[] = $value->toArray();
            } elseif ($value instanceof AbstractScalarSchema) {
                $result[] = $value->value;
            }
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
        $count = count($this);
        $min = $this->getMinCount();
        $max = $this->getMaxCount();
        if ($count < $min) {
            $result['few'] = "Too few array elements";
        }
        if ($max !== null && $count > $max) {
            $result['much'] = "Too much array elements";
        }
        foreach ($this as $n => $item) {
            $errors = $item->validate();
            if (!empty($errors)) {
                $result[$n] = $errors;
            }
        }
        return $result;
    }

    protected function getMinCount(): int
    {
        return 0;
    }

    protected function getMaxCount(): ?int
    {
        return null;
    }
}
