<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractAssocSchema;

class AssocColorSchema extends AbstractAssocSchema
{
    protected function getTypeClass(): string
    {
        return ColorSchema::class;
    }
}
