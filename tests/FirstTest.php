<?php

use Iwan07\Schema\demo\enum\ColorEnum;
use Iwan07\Schema\demo\Schema\AddressOrMetroSchema;
use Iwan07\Schema\demo\Schema\AddressSchema;
use Iwan07\Schema\demo\Schema\AssocColorSchema;
use Iwan07\Schema\demo\Schema\AssocSchema;
use Iwan07\Schema\demo\Schema\ItemSchema;
use Iwan07\Schema\demo\Schema\ItemsSchema;
use Iwan07\Schema\demo\Schema\MetroSchema;
use Iwan07\Schema\demo\Schema\MetrosSchema;
use Iwan07\Schema\demo\Schema\TargetSchema;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    public function testOne()
    {
        $address = [
            'country' => 'Russia',
            'city' => 'Moscow',
            'coords' => [25.001, 73.329],
        ];
        $addr = AddressSchema::restore($address);
        $this->assertEquals('Russia', $addr->country);
        $this->assertEquals(25.001, $addr->coords[0]);
        $this->assertEquals('{"country":"Russia","city":"Moscow","coords":[25.001,73.329]}', (string)$addr);

        $metro1 = [
            'station' => 'station name',
            'color' => 'red',
            'time' => 10,
        ];
        $met1 = MetroSchema::restore($metro1);
        $this->assertEquals('{"station":"station name","color":"red","time":10}', (string)$met1);

        $metro = [
            $metro1,
        ];
        $met = MetrosSchema::restore($metro);
        $this->assertEquals(10, $met[0]->time);
        $this->assertEquals('[{"station":"station name","color":"red","time":10}]', (string)$met);

        $item1 = [
            'id' => 1,
            'name' => 'Alex',
            'address' => $address,
            'metro' => $metro,
        ];
        $it1 = ItemSchema::restore($item1);
        $this->assertEquals('{"id":1,"name":"Alex","address":{"country":"Russia","city":"Moscow","coords":[25.001,73.329]},"metro":[{"station":"station name","color":"red","time":10}],"checked":null}', (string)$it1);

        $items = [
            $item1,
        ];
        $its = ItemsSchema::restore($items);
        $this->assertEquals('[{"id":1,"name":"Alex","address":{"country":"Russia","city":"Moscow","coords":[25.001,73.329]},"metro":[{"station":"station name","color":"red","time":10}],"checked":null}]', $its);
        $this->assertEquals(ColorEnum::red, $its[0]->metro[0]->color);

        $target = [
            'items' => $items,
            'total' => 17,
            'pages' => 2,
        ];
        $tg = TargetSchema::restore($target);
        $this->assertEquals('{"items":[{"id":1,"name":"Alex","address":{"country":"Russia","city":"Moscow","coords":[25.001,73.329]},"metro":[{"station":"station name","color":"red","time":10}],"checked":null}],"total":17,"pages":2}', (string)$tg);
        $this->assertEquals('Alex', $tg->items[0]->name);

        $this->assertTrue($tg->isValid());
    }

    public function testEnum()
    {
        $metroNew = new MetroSchema;
        $metroNew->station = "abc station";
        $metroNew->color = ColorEnum::red;
        $metroNew->time = 10;

        $this->assertEquals('{"station":"abc station","color":"red","time":10}', (string)$metroNew);
        $this->assertTrue($metroNew->isValid());
    }

    public function testItem()
    {
        $item = new ItemSchema;
        $item->id = 1;
        $item->checked = true;

        $items = new ItemsSchema;
        $items[5] = $item;
        $items[1] = ItemSchema::restore(['id' => 123]);
        $items[3] = ItemSchema::restore(['id' => 12345]);
        unset($items[0]);
        unset($items[1]);
        $items[] = ItemSchema::restore(['id' => 11111]);

        $ids = array_map(function ($x) {
            return $x['id'];
        }, $items->toArray());

        $this->assertEquals([123, 12345, null, 1, 11111], $ids);
        $this->assertEquals(5, count($items));
    }

    public function testAssoc()
    {
        $x = new AssocSchema;
        $x->first->station = "Station abcde";
        $x->first->color = ColorEnum::green;
        $x->{"Second station"}->time = 124;

        $this->assertEquals(124, $x->{"Second station"}->time);
        $this->assertEquals('{"first":{"station":"Station abcde","color":"green","time":null},"Second station":{"station":null,"color":null,"time":124}}', (string)$x);
    }

    public function testDirectAssoc()
    {
        $x = new AssocColorSchema;
        $x->first = ColorEnum::red;
        $x->first = "green";
        $this->assertEquals(ColorEnum::green, $x->first);
    }

    public function testAddCoord()
    {
        $x = new AddressSchema;
        $x->country = 'ABCDE';
        $x->city = 'ABCD';
        $x->coords = [11.1, 12.4];
        $this->assertEquals(11.1, $x->coords[0]);
        $this->assertEquals(12.4, $x->coords[1]);
        $this->assertEquals([11.1, 12.4], $x->coords->toArray());
    }

    public function testOrSchema()
    {
        $choose = new AddressOrMetroSchema;

        $choose->station = 'Station 1';
        $this->assertEquals('{"station":"Station 1","color":null,"time":null}', (string)$choose);
        $this->assertEquals('Iwan07\Schema\demo\Schema\MetroSchema', $choose->getActualSchema());

        $choose->city = 'Moscow';
        $this->assertEquals('{"country":null,"city":"Moscow","coords":[]}', (string)$choose);
        $this->assertEquals('Iwan07\Schema\demo\Schema\AddressSchema', $choose->getActualSchema());
    }
}
