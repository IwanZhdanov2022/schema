<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractObjectSchema;
use Iwan07\Schema\scalar\StringSchema;

/**
 * @property string  $country    Страна
 * @property string  $city       Город
 * @property array   $coords     Координаты
 */
class AddressSchema extends AbstractObjectSchema
{
    protected StringSchema $country;
    protected StringSchema $city;
    protected CoordsSchema $coords;
}
