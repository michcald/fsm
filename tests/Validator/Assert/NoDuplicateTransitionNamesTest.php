<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Validator\Assert\NoDuplicateTransitionNamesAssert;

class NoDuplicateTransitionNamesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\DuplicateTransitionException
     * @expectedExceptionMessageRegExp #Transition <.*> is already used in FSM <.*>#
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
                new Transition('t1', 's2', 's3'),
            ))
        ;

        $assert = new NoDuplicateTransitionNamesAssert();
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

        $assert = new NoDuplicateTransitionNamesAssert();
        $assert->validate($fsm, false);
    }
}
