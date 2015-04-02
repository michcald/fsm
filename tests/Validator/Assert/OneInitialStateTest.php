<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Validator\Assert\OneInitialStateAssert;

class OneInitialStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\MissingInitialStateException
     * @expectedExceptionMessageRegExp #FSM <.*> must have an initial state#
     */
    public function testNoInitialStateWithExceptions()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1'),
            new State('s2'),
            new State('s1'),
        ));

        $assert = new OneInitialStateAssert();
        $assert->validate($fsm);
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\MultipleInitialStatesException
     * @expectedExceptionMessageRegExp #FSM <.*> has multiple initial states#
     */
    public function testMultipleInitialStatesWithExceptions()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1', true),
            new State('s2'),
            new State('s1', true),
        ));

        $assert = new OneInitialStateAssert();
        $assert->validate($fsm);
    }

    public function testBadAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1', false),
            new State('s2'),
            new State('s1'),
        ));

        $assert = new OneInitialStateAssert();
        $result = $assert->validate($fsm, false);

        $this->assertFalse($result);
    }

    public function testGoodAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1', true),
            new State('s2'),
            new State('s3'),
        ));

        $assert = new OneInitialStateAssert();
        $result = $assert->validate($fsm, false);

        $this->assertTrue($result);
    }
}
