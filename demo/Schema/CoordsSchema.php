<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractArraySchema;
use Iwan07\Schema\scalar\FloatSchema;

class CoordsSchema extends AbstractArraySchema
{
    protected function getTypeClass(): string
    {
        return FloatSchema::class;
    }

    protected function getMinCount(): int
    {
        return 2;
    }

    protected function getMaxCount(): ?int
    {
        return 2;
    }
}
