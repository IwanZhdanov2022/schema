<?php

namespace Iwan07\Schema\base;

abstract class AbstractEnumSchema extends AbstractScalarSchema
{
    protected $enumObj = null;

    abstract protected function getEnumClass(): string;

    public function __set(string $property, $value): void
    {
        if ($property === 'value') {
            if (is_null($value)) {
                $this->enumObj = null;
                return;
            }
            foreach ($this->getEnumClass()::cases() as $case) {
                if ($case->name === $value || $case->value === $value || $case === $value) {
                    $this->enumObj = $case;
                    return;
                }
            }
            throw new \Exception('Unrecognized enum value');
        }
    }

    public function __get(string $property)
    {
        if ($property === 'value') {
            return $this->enumObj;
        }
        return null;
    }

    // public function validate(): array
    // {
    //     return !is_null($this->enumObj);
    // }
}
