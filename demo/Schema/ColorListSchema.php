<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractArraySchema;

class ColorListSchema extends AbstractArraySchema
{
    protected function getTypeClass(): string
    {
        return ColorSchema::class;
    }
}
