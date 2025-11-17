<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractOrSchema;

/**
 * @property string      $country    Страна
 * @property string      $city       Город
 * @property array       $coords     Координаты
 * @property string      $station    Название станции
 * @property ColorEnum   $color      Цвет ветки
 * @property int         $time       Время в пути до станции
 */
class AddressOrMetroSchema extends AbstractOrSchema
{
    protected function getAvailableSchemas(): array
    {
        return [
            AddressSchema::class,
            MetroSchema::class,
        ];
    }
}
