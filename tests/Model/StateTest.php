<?php

use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Interfaces\StateInterface;

class StateTest extends \PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $this->assertNotEquals(StateInterface::TYPE_INITIAL, StateInterface::TYPE_NORMAL);
        $this->assertNotEquals(StateInterface::TYPE_INITIAL, StateInterface::TYPE_FINAL);
        $this->assertNotEquals(StateInterface::TYPE_FINAL, StateInterface::TYPE_NORMAL);
    }

    public function testCreate()
    {
        $normalState1Name = 'stateNormal';
        $normalState1 = new State($normalState1Name, StateInterface::TYPE_NORMAL);

        $this->assertEquals($normalState1Name, $normalState1->getName());
        $this->assertEquals(StateInterface::TYPE_NORMAL, $normalState1->getType());

        $initialStateName = 'stateInitial';
        $initialState = new State($initialStateName, StateInterface::TYPE_INITIAL);

        $this->assertEquals($initialStateName, $initialState->getName());
        $this->assertEquals(StateInterface::TYPE_INITIAL, $initialState->getType());

        $finalStateName = 'stateFinal';
        $finalState = new State($finalStateName, StateInterface::TYPE_FINAL);

        $this->assertEquals($finalStateName, $finalState->getName());
        $this->assertEquals(StateInterface::TYPE_FINAL, $finalState->getType());

        $emptyName = '';
        $emptyState = new State($emptyName, StateInterface::TYPE_NORMAL);

        $this->assertEquals($emptyName, $emptyState->getName());
        $this->assertEquals(StateInterface::TYPE_NORMAL, $emptyState->getType());
    }

    public function testProperty()
    {
        $s1 = new State('s1', StateInterface::TYPE_INITIAL);
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
