<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractObjectSchema;
use Iwan07\Schema\scalar\BoolSchema;
use Iwan07\Schema\scalar\IntSchema;
use Iwan07\Schema\scalar\StringSchema;

/**
 * @property int     $id         Id
 * @property string  $name       ФИО
 * @property         $address    Адрес
 * @property         $metro      Станция метро
 * @property         $checked    Проверено
 */
class ItemSchema extends AbstractObjectSchema
{
    protected IntSchema $id;
    protected StringSchema $name;
    protected AddressSchema $address;
    protected MetrosSchema $metro;
    protected BoolSchema $checked;
}
