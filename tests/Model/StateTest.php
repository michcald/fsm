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
        $normalState1Name = 'stateNormal1';
        $normalState1 = new State();
        $normalState1->setName($normalState1Name);

        $this->assertEquals($normalState1Name, $normalState1->getName());
        $this->assertEquals(StateInterface::TYPE_NORMAL, $normalState1->getType());

        $normalState2Name = 'stateNormal2';
        $normalState2 = new State();
        $normalState2
            ->setName($normalState2Name)
            ->setType(StateInterface::TYPE_NORMAL)
        ;

        $this->assertEquals($normalState2Name, $normalState2->getName());
        $this->assertEquals(StateInterface::TYPE_NORMAL, $normalState2->getType());

        $initialStateName = 'stateInitial';
        $initialState = new State();
        $initialState
            ->setName($initialStateName)
            ->setType(StateInterface::TYPE_INITIAL)
        ;

        $this->assertEquals($initialStateName, $initialState->getName());
        $this->assertEquals(StateInterface::TYPE_INITIAL, $initialState->getType());

        $finalStateName = 'stateFinal';
        $finalState = new State();
        $finalState
            ->setName($finalStateName)
            ->setType(StateInterface::TYPE_FINAL)
        ;

        $this->assertEquals($finalStateName, $finalState->getName());
        $this->assertEquals(StateInterface::TYPE_FINAL, $finalState->getType());
    }

    public function testBad()
    {
        $normalState1Name = '';
        $normalState1 = new State($normalState1Name);

        $this->assertEquals($normalState1Name, $normalState1->getName());
        $this->assertEquals(StateInterface::TYPE_NORMAL, $normalState1->getType());
    }
}
