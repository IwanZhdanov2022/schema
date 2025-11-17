<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractObjectSchema;
use Iwan07\Schema\scalar\StringSchema;

/**
 * @var string  $country    Страна
 * @var string  $city       Город
 * @var array   $coords     Координаты
 */
class AddressSchema extends AbstractObjectSchema
{
    protected StringSchema $country;
    protected StringSchema $city;
    protected CoordsSchema $coords;
}
