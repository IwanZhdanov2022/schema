<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractOrSchema;

/**
 * @var string      $country    Страна
 * @var string      $city       Город
 * @var array       $coords     Координаты
 * @var string      $station    Название станции
 * @var ColorEnum   $color      Цвет ветки
 * @var int         $time       Время в пути до станции
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
