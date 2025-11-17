<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\demo\enum\ColorEnum;
use Iwan07\Schema\base\AbstractObjectSchema;
use Iwan07\Schema\scalar\IntSchema;
use Iwan07\Schema\scalar\StringSchema;

/**
 * @property string      $station    Название станции
 * @property ColorEnum   $color      Цвет ветки
 * @property int         $time       Время в пути до станции
 */
class MetroSchema extends AbstractObjectSchema
{
    protected StringSchema $station;
    protected ColorSchema $color;
    protected IntSchema $time;
}
