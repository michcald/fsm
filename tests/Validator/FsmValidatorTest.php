<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Validator\FsmValidator;
use Michcald\Fsm\Validator\Assert;

class FsmValidatorTest extends \PHPUnit_Framework_TestCase
{
    private function getNewInvalidFsm()
    {
        $fsm = new Fsm('fsm1');

        $s1 = new State('s1', true);
        $s2 = new State('s2');
        $s3 = new State('s3');
        $s4 = new State('s4', false, true);

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

    private function getNewValidFsm()
    {
        $s1 = new State('s1', true);
        $s2 = new State('s2');
        $s3 = new State('s3');
        $s4 = new State('s4');
        $s5 = new State('s5');
        $s6 = new State('s6');
        $s7 = new State('s7', false, true);
        $s8 = new State('s8', false, true);

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

        return $fsm1;
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\MultipleInitialStatesException
     */
    public function testOneInitialStateAssertException1()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1', true),
            new State('s2', true),
        ));

        $validator = new FsmValidator();
        $validator->addAssert(new Assert\OneInitialStateAssert());
        $validator->validate($fsm);
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\MissingInitialStateException
     */
    public function testOneInitialStateAssertException2()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1'),
            new State('s2'),
        ));

        $validator = new FsmValidator();
        $validator->addAssert(new Assert\OneInitialStateAssert());
        $validator->validate($fsm);
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\UndefinedStateException
     */
    public function testNoTransitionWithUndefinedNamesAssertException()
    {
        $fsm = new Fsm('fsm');
        $fsm
            ->setStates(array(
                new State('s1'),
                new State('s2'),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t2', 's2', 's3'),
            ))
        ;

        $validator = new FsmValidator();
        $validator->addAssert(new Assert\NoTransitionWithUndefinedStatesAssert());
        $validator->validate($fsm);
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\DuplicateTransitionException
     */
    public function testNoDuplicateTransitionNamesAssertException()
    {
        $fsm = new Fsm('fsm');
        $fsm
            ->setStates(array(
                new State('s1'),
                new State('s2'),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t1', 's2', 's3'),
            ))
        ;

        $validator = new FsmValidator();
        $validator->addAssert(new Assert\NoDuplicateTransitionNamesAssert());
        $validator->validate($fsm);
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\DuplicateStateException
     */
    public function testNoDuplicateStateAssertException()
    {
        $fsm = new Fsm('fsm');
        $fsm
            ->setStates(array(
                new State('s1', true),
                new State('s1', false, true),
                new State('s2'),
            ))
        ;

        $validator = new FsmValidator();
        $validator->addAssert(new Assert\NoDuplicateStatesAssert());
        $validator->validate($fsm);
    }

    public function testReturnValue()
    {
        $fsm = $this->getNewInvalidFsm();
        $validator = new FsmValidator();
        $validator->validate($fsm);

        $fsm = $this->getNewValidFsm();
        $validator = new FsmValidator();
        $validator->validate($fsm);

        // build up the validator adding asserts
        $fsm = $this->getNewValidFsm();
        $validator = new FsmValidator();
        $validator->addAssert(new Assert\NoDuplicateStatesAssert());

        $validator->validate($fsm);
    }
}
