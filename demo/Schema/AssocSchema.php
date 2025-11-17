<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractAssocSchema;

class AssocSchema extends AbstractAssocSchema
{
    protected function getTypeClass(): string
    {
        return MetroSchema::class;
    }
}
