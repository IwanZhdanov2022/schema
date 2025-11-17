<?php

namespace Iwan07\Schema\demo\Schema;

use Iwan07\Schema\base\AbstractObjectSchema;
use Iwan07\Schema\scalar\IntSchema;

/**
 * @var array   $items Список пользователей
 * @var int     $total Всего
 * @var int     $pages Всего страниц
 */
class TargetSchema extends AbstractObjectSchema
{
    protected ItemsSchema $items;
    protected IntSchema $total;
    protected IntSchema $pages;
}
