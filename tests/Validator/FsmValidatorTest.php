<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransaction;
use Michcald\Fsm\Validator\FsmValidator;

class FsmValidatorTest extends \PHPUnit_Framework_TestCase
{
    private function getNewInvalidFsm()
    {
        $fsm = new Fsm('fsm1');

        $s1 = new FsmState('s1', FsmState::TYPE_START);
        $s2 = new FsmState('s2', FsmState::TYPE_NORMAL);
        $s3 = new FsmState('s3');
        $s4 = new FsmState('s4', FsmState::TYPE_END);

        $t1 = new FsmTransaction('t1', 's1', 's2');
        $t2 = new FsmTransaction('t2', 's1', 's3');
        $t3 = new FsmTransaction('t3', 's3', 's1');
        $t4 = new FsmTransaction('t4', 's2', 's4');

        $fsm->addState($s1);
        $fsm->addState($s2);
        $fsm->addState($s3);
        $fsm->addState($s4);

        $fsm->addTransaction($t1);
        $fsm->addTransaction($t2);
        $fsm->addTransaction($t3);
        $fsm->addTransaction($t4);

        $fsm->addTransaction(
            new FsmTransaction('s123', 's123', 's456')
        );

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
