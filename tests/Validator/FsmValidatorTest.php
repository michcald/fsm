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
        $fsm = new Fsm();
        $fsm->setName('fsm1');

        $s1 = new State();
        $s1
            ->setName('s1')
            ->setType(StateInterface::TYPE_INITIAL)
        ;

        $s2 = new State();
        $s2
            ->setName('s2')
            ->setType(StateInterface::TYPE_NORMAL)
        ;

        $s3 = new State();
        $s3->setName('s3');

        $s4 = new State();
        $s4
            ->setName('s4')
            ->setType(StateInterface::TYPE_FINAL)
        ;

        $t1 = new Transition();
        $t1
            ->setName('t1')
            ->setFromStateName('s1')
            ->setToStateName('s2')
        ;

        $t2 = new Transition();
        $t2
            ->setName('t2')
            ->setFromStateName('s1')
            ->setToStateName('s3')
        ;

        $t3 = new Transition();
        $t3
            ->setName('t3')
            ->setFromStateName('s3')
            ->setToStateName('s1')
        ;

        $t4 = new Transition();
        $t4
            ->setName('t4')
            ->setFromStateName('s2')
            ->setToStateName('s4')
        ;

        $fsm->addState($s1);
        $fsm->addState($s2);
        $fsm->addState($s3);
        $fsm->addState($s4);

        $fsm->addTransition($t1);
        $fsm->addTransition($t2);
        $fsm->addTransition($t3);
        $fsm->addTransition($t4);

        $ty = new Transition();
        $ty
            ->setName('t123')
            ->setFromStateName('s123')
            ->setToStateName('s456')
        ;

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
