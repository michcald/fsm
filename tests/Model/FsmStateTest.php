<?php

use Michcald\Fsm\Model\FsmState;

class FsmStateTest extends \PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $this->assertNotEquals(FsmState::TYPE_START, FsmState::TYPE_NORMAL);
        $this->assertNotEquals(FsmState::TYPE_START, FsmState::TYPE_END);
        $this->assertNotEquals(FsmState::TYPE_END, FsmState::TYPE_NORMAL);
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

        $startStateName = 'stateStart';
        $startState = new FsmState($startStateName, FsmState::TYPE_START);
        $this->assertEquals($startStateName, $startState->getName());
        $this->assertEquals(FsmState::TYPE_START, $startState->getType());

        $endStateName = 'stateEnd';
        $endState = new FsmState($endStateName, FsmState::TYPE_END);
        $this->assertEquals($endStateName, $endState->getName());
        $this->assertEquals(FsmState::TYPE_END, $endState->getType());
    }

    public function testBad()
    {
        $normalState1Name = '';
        $normalState1 = new FsmState($normalState1Name);
        $this->assertEquals($normalState1Name, $normalState1->getName());
        $this->assertEquals(FsmState::TYPE_NORMAL, $normalState1->getType());
    }
}
