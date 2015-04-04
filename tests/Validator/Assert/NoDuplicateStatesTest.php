<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Validator\Assert\NoDuplicateStatesAssert;

class NoDuplicateStatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\DuplicateStateException
     * @expectedExceptionMessageRegExp #State <.*> is already used in FSM <.*>#
     */
    public function testBadAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1'),
            new State('s2'),
            new State('s1'),
        ));

        $assert = new NoDuplicateStatesAssert();
        $assert->validate($fsm);
    }

    public function testGoodAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1'),
            new State('s2'),
            new State('s3'),
        ));

        $assert = new NoDuplicateStatesAssert();
        $assert->validate($fsm);
    }
}
