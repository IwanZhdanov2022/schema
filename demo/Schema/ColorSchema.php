<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\demo\enum\ColorEnum;
use Iwan07\Schema\base\AbstractEnumSchema;

class ColorSchema extends AbstractEnumSchema
{
    protected function getEnumClass(): string
    {
        return ColorEnum::class;
    }
}
