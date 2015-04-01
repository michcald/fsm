<?php

use Michcald\Fsm\Model\Transition;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $t1 = new Transition('t1', 's1', 's2');

        $this->assertEquals('t1', $t1->getName());
        $this->assertEquals('s1', $t1->getFromStateName());
        $this->assertEquals('s2', $t1->getToStateName());

        $t2 = new Transition('', '', '');

        $this->assertEmpty($t2->getName());
        $this->assertEmpty($t2->getFromStateName());
        $this->assertEmpty($t2->getToStateName());
    }

    public function testProperty()
    {
        $t1 = new Transition('t1', 's1', 's2');
        $t1
            ->addProperty('color', 'blue')
            ->addProperty('height', '')
        ;

        $this->assertEquals('blue', $t1->getProperty('color'));
        $this->assertEmpty($t1->getProperty('heigth'));
        $this->assertNull($t1->getProperty('width'));
        $this->assertEquals('123', $t1->getProperty('width', '123'));
        $this->assertFalse($t1->getProperty('width', false));
        $this->assertEmpty($t1->getProperty('jasvd', ''));
    }
}
