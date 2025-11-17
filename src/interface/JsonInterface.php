<?php

namespace Iwan07\Schema\interface;

interface JsonInterface
{
    public function toArray(): array;
    public static function restore(array $data): static;
}
