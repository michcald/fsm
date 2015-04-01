<?php

use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Interfaces\StateInterface;

class StateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $s1Name = 'stateNormal';
        $s1 = new State($s1Name);

        $this->assertEquals($s1Name, $s1->getName());
        $this->assertFalse($s1->getIsFinal());
        $this->assertFalse($s1->getIsInitial());

        $s2Name = 'stateInitial';
        $s2 = new State($s2Name);
        $s2->setIsInitial(true);

        $this->assertEquals($s2Name, $s2->getName());
        $this->assertTrue($s2->getIsInitial());
        $this->assertFalse($s2->getIsFinal());

        $s3Name = 'stateFinal';
        $s3 = new State($s3Name);
        $s3->setIsFinal(true);

        $this->assertEquals($s3Name, $s3->getName());
        $this->assertFalse($s3->getIsInitial());
        $this->assertTrue($s3->getIsFinal());

        $s4Name = 'stateFinalInitial';
        $s4 = new State($s4Name);
        $s4
            ->setIsInitial(true)
            ->setIsFinal(true)
        ;

        $this->assertEquals($s4Name, $s4->getName());
        $this->assertTrue($s4->getIsInitial());
        $this->assertTrue($s4->getIsFinal());
    }

    public function testProperty()
    {
        $s1 = new State('s1');
        $s1
            ->addProperty('color', 'blue')
            ->addProperty('height', '')
        ;

        $this->assertEquals('blue', $s1->getProperty('color'));
        $this->assertEmpty($s1->getProperty('heigth'));
        $this->assertNull($s1->getProperty('width'));
        $this->assertEquals('123', $s1->getProperty('width', '123'));
        $this->assertFalse($s1->getProperty('width', false));
        $this->assertEmpty($s1->getProperty('jasvd', ''));
    }
}
