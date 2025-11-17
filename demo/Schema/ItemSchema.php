<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractObjectSchema;
use Iwan07\Schema\scalar\BoolSchema;
use Iwan07\Schema\scalar\IntSchema;
use Iwan07\Schema\scalar\StringSchema;

/**
 * @var int     $id         Id
 * @var string  $name       ФИО
 * @var         $address    Адрес
 * @var         $metro      Станция метро
 * @var         $checked    Проверено
 */
class ItemSchema extends AbstractObjectSchema
{
    protected IntSchema $id;
    protected StringSchema $name;
    protected AddressSchema $address;
    protected MetrosSchema $metro;
    protected BoolSchema $checked;
}
