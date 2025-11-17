<?php

use Iwan07\Schema\demo\enum\ColorEnum;
use Iwan07\Schema\demo\Schema\ColorListSchema;
use Iwan07\Schema\demo\Schema\ItemSchema;
use Iwan07\Schema\demo\Schema\MetroSchema;
use PHPUnit\Framework\TestCase;

class AnyWithAnyTest extends TestCase
{
    // Object
    // Array
    public function testObjectWithArray()
    {
        $item = ItemSchema::restore([
            'metro' => [
                [
                    'station' => 'Some station',
                    'color' => 'red',
                    'time' => 12,
                ],
            ],
        ]);
        $this->assertEquals('Some station', $item->metro[0]->station);
        $item->metro[0]->station = "Another station";
        $this->assertEquals('Another station', $item->metro[0]->station);
        $item->metro[1] = MetroSchema::restore(['station' => 'abcd', 'time' => 3]);
        $item->metro[] = MetroSchema::restore(['station' => 'abcd2', 'time' => 6]);
        $this->assertEquals(3, count($item->metro));
        $item->metro[] = ['station' => 'Added', 'color' => 'green', 'time' => 1];
        $this->assertEquals('Added', $item->metro[3]->station);
        $this->assertEquals(4, count($item->metro));
    }

    public function testArrayWithObject()
    {
        $colors = ColorListSchema::restore(['red']);
        $colors[1] = 'green';
        $colors[] = ColorEnum::red;
        $this->assertEquals(3, count($colors));
        $this->assertEquals('green', $colors[1]->name);
        unset($colors[1]);
        $this->assertEquals('red', $colors[1]->name);
    }
}
