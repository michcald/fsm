<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Interfaces\StateInterface;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Validator\FsmValidator;

class FsmValidatorTest extends \PHPUnit_Framework_TestCase
{
    private function getNewInvalidFsm()
    {
        $fsm = new Fsm('fsm1');

        $s1 = new State('s1', StateInterface::TYPE_INITIAL);
        $s2 = new State('s2', StateInterface::TYPE_NORMAL);
        $s3 = new State('s3', StateInterface::TYPE_NORMAL);
        $s4 = new State('s4', StateInterface::TYPE_FINAL);

        $t1 = new Transition('t1', 's1', 's2');
        $t2 = new Transition('t2', 's1', 's3');
        $t3 = new Transition('t3', 's3', 's1');
        $t4 = new Transition('t4', 's2', 's4');

        $fsm->addState($s1);
        $fsm->addState($s2);
        $fsm->addState($s3);
        $fsm->addState($s4);

        $fsm->addTransition($t1);
        $fsm->addTransition($t2);
        $fsm->addTransition($t3);
        $fsm->addTransition($t4);

        $ty = new Transition('t123', 's123', 's456');
        $fsm->addTransition($ty);

        return $fsm;
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\StateNotFoundException
     * @expectedExceptionMessageRegExp #State <.*> not found in FSM <.*>#
     */
    public function testException()
    {
        $fsm = $this->getNewInvalidFsm();

        $validator = new FsmValidator();
        $validator->validate($fsm);
    }
}
