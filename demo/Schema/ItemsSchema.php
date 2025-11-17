<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractArraySchema;

class ItemsSchema extends AbstractArraySchema
{
    protected function getTypeClass(): string
    {
        return ItemSchema::class;
    }
}
