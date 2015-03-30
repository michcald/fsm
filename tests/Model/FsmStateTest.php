<?php

use Michcald\Fsm\Model\FsmState;

class FsmStateTest extends \PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $this->assertNotEquals(FsmState::TYPE_INITIAL, FsmState::TYPE_NORMAL);
        $this->assertNotEquals(FsmState::TYPE_INITIAL, FsmState::TYPE_FINAL);
        $this->assertNotEquals(FsmState::TYPE_FINAL, FsmState::TYPE_NORMAL);
    }

    public function testCreate()
    {
        $normalState1Name = 'stateNormal1';
        $normalState1 = new FsmState($normalState1Name);
        $this->assertEquals($normalState1Name, $normalState1->getName());
        $this->assertEquals(FsmState::TYPE_NORMAL, $normalState1->getType());

        $normalState2Name = 'stateNormal2';
        $normalState2 = new FsmState($normalState2Name, FsmState::TYPE_NORMAL);
        $this->assertEquals($normalState2Name, $normalState2->getName());
        $this->assertEquals(FsmState::TYPE_NORMAL, $normalState2->getType());

        $initialStateName = 'stateInitial';
        $initialState = new FsmState($initialStateName, FsmState::TYPE_INITIAL);
        $this->assertEquals($initialStateName, $initialState->getName());
        $this->assertEquals(FsmState::TYPE_INITIAL, $initialState->getType());

        $finalStateName = 'stateFinal';
        $finalState = new FsmState($finalStateName, FsmState::TYPE_FINAL);
        $this->assertEquals($finalStateName, $finalState->getName());
        $this->assertEquals(FsmState::TYPE_FINAL, $finalState->getType());
    }

    public function testBad()
    {
        $normalState1Name = '';
        $normalState1 = new FsmState($normalState1Name);
        $this->assertEquals($normalState1Name, $normalState1->getName());
        $this->assertEquals(FsmState::TYPE_NORMAL, $normalState1->getType());
    }
}
