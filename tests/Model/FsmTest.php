<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Model\Interfaces\StateInterface;

class FsmTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $s1 = new State('s1', StateInterface::TYPE_INITIAL);
        $s2 = new State('s2', StateInterface::TYPE_NORMAL);
        $s3 = new State('s3', StateInterface::TYPE_NORMAL);
        $s4 = new State('s4', StateInterface::TYPE_NORMAL);
        $s5 = new State('s5', StateInterface::TYPE_NORMAL);
        $s6 = new State('s6', StateInterface::TYPE_NORMAL);
        $s7 = new State('s7', StateInterface::TYPE_FINAL);
        $s8 = new State('s8', StateInterface::TYPE_FINAL);

        $t1 = new Transition('t1', 's1', 's2');
        $t2 = new Transition('t2', 's1', 's3');
        $t3 = new Transition('t3', 's2', 's1');
        $t4 = new Transition('t4', 's3', 's4');
        $t5 = new Transition('t5', 's4', 's5');
        $t6 = new Transition('t6', 's5', 's7');
        $t7 = new Transition('t7', 's5', 's6');
        $t8 = new Transition('t8', 's6', 's8');

        $fsm1 = new Fsm('fsm1');
        $fsm1
            ->addState($s1)
            ->addState($s2)
            ->addState($s3)
            ->addState($s4)
            ->addState($s5)
            ->addState($s6)
            ->addState($s7)
            ->addState($s8)
            ->addTransition($t1)
            ->addTransition($t2)
            ->addTransition($t3)
            ->addTransition($t4)
            ->addTransition($t5)
            ->addTransition($t6)
            ->addTransition($t7)
            ->addTransition($t8)
        ;

        $this->assertCount(8, $fsm1->getStates());
        $this->assertCount(8, $fsm1->getTransitions());

        $this->assertTrue($fsm1->hasInitialState());
        $this->assertTrue($fsm1->hasFinalState());

        $this->assertTrue($fsm1->hasStateByName('s4'));
        $this->assertFalse($fsm1->hasStateByName('s44'));
        $this->assertFalse($fsm1->hasStateByName(''));

        $this->assertTrue($fsm1->hasTransitionByName('t7'));
        $this->assertFalse($fsm1->hasTransitionByName('t31'));
        $this->assertFalse($fsm1->hasTransitionByName(''));

        $this->assertEquals('s1', $fsm1->getInitialState()->getName());
    }

    public function testBadCreate()
    {
        $s1 = new State('s1', StateInterface::TYPE_NORMAL);

        $t1 = new Transition('t1', 's1', 's2');

        $fsm1 = new Fsm('fsm1');
        $fsm1
            ->addState($s1)
            ->addTransition($t1)
        ;

        $this->assertCount(1, $fsm1->getStates());
        $this->assertCount(1, $fsm1->getTransitions());

        $this->assertFalse($fsm1->hasInitialState());
        $this->assertFalse($fsm1->hasFinalState());

        $this->assertFalse($fsm1->hasStateByName('s4'));
        $this->assertFalse($fsm1->hasStateByName(''));

        $this->assertTrue($fsm1->hasTransitionByName('t1'));
        $this->assertFalse($fsm1->hasTransitionByName('t31'));
        $this->assertFalse($fsm1->hasTransitionByName(''));

        $this->assertNull($fsm1->getInitialState());
    }

    public function testProperty()
    {
        $fsm1 = new Fsm('fsm1');
        $fsm1
            ->addProperty('color', 'blue')
            ->addProperty('height', '')
        ;

        $this->assertEquals('blue', $fsm1->getProperty('color'));
        $this->assertEmpty($fsm1->getProperty('heigth'));
        $this->assertNull($fsm1->getProperty('width'));
        $this->assertEquals('123', $fsm1->getProperty('width', '123'));
        $this->assertFalse($fsm1->getProperty('width', false));
        $this->assertEmpty($fsm1->getProperty('jasvd', ''));
    }
}