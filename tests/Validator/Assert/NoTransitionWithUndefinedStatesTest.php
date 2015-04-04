<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Validator\Assert\NoTransitionWithUndefinedStatesAssert;

class NoTransitionWithUndefinedStatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\UndefinedStateException
     * @expectedExceptionMessageRegExp #Cannot find state <.*> for FSM <.*> used in transition <.*>#
     */
    public function testBadAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm
            ->setStates(array(
                new State('s1'),
                new State('s2'),
                new State('s3'),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t2', 's2', 's5'),
            ))
        ;

        $assert = new NoTransitionWithUndefinedStatesAssert();
        $assert->validate($fsm);
    }

    public function testGoodAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm
            ->setStates(array(
                new State('s1'),
                new State('s2'),
                new State('s3'),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t2', 's2', 's3'),
            ))
        ;

        $assert = new NoTransitionWithUndefinedStatesAssert();
        $assert->validate($fsm, false);
    }
}
