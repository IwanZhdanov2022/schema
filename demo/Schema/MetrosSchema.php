<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractArraySchema;

class MetrosSchema extends AbstractArraySchema
{
    protected function getTypeClass(): string
    {
        return MetroSchema::class;
    }
}
