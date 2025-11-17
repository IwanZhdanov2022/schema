<?php

namespace Iwan07\Schema\base;

abstract class AbstractOrSchema extends AbstractObjectSchema
{
    protected AbstractObjectSchema $data;

    abstract protected function getAvailableSchemas(): array;

    public function __construct()
    {
        $this->data = new ($this->getAvailableSchemas()[0]);
    }

    public function __set(string $property, $value): void
    {
        $this->data->$property = $value;
        $data = $this->toArray();
        $data[$property] = $value;

        $classList = $this->getAvailableSchemas();
        $len = count($classList);
        $flipped = array_flip($classList);
        $pos = $flipped[$this->data::class];
        for ($a = $pos; $a < $pos + $len; $a++) {
            $dataClass = $classList[$a % $len]::restore($data);
            if ($dataClass->$property) {
                $this->data = $dataClass;
                return;
            }
        }
    }

    public function __get(string $property)
    {
        return $this->data->$property;
    }

    public function getActualSchema(): string
    {
        return $this->data::class;
    }

    public static function restore(array $data): static
    {
        $obj = new static;
        $dataClass = $obj->getClassByData($data);
        $obj->data = $dataClass;
        return $obj;
    }

    public function toArray(): array
    {
        return $this->data->toArray();
    }

    protected function changeClass(string $newDataClass): void
    {
        $data = $this->data->toArray();
        $newData = $newDataClass::restore($data);
        $this->data = $newData;
    }

    protected function getClassByData(array $data): AbstractObjectSchema
    {
        $first = null;
        foreach ($this->getAvailableSchemas() as $class) {
            if (is_null($first)) {
                $first = $class;
            }
            $obj = $class::restore($data);
            if ($obj->isValid()) {
                return $obj;
            }
        }
        return new $first;
    }
}
