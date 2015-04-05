<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Validator\FsmValidator;
use Michcald\Fsm\Accessor\FsmAccessor;
use Michcald\Fsm\Validator\Assert;

class FsmAccessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Michcald\Fsm\Exception\Accessor\InvalidStatefulPropertyException
     */
    public function testStatefulPropertyValue()
    {
        $fsm = new Fsm('my_fsm');
        $fsm
            ->setStates(array(
                new State('s1', true),
                new State('s2'),
                new State('s3', false, true),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t2', 's2', 's3'),
            ))
        ;

        $validator = new FsmValidator();
        $validator->validate($fsm);

        $accessor = new FsmAccessor($fsm, $validator, 'Document', 'myState2');

        $obj = new Document();
        $accessor->setInitialState($obj);

        $accessor->doTransition($obj, 't1');
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Accessor\InvalidStatefulClassException
     */
    public function testInvalidStatefulClassValue()
    {
        $fsm = new Fsm('my_fsm');
        $fsm
            ->setStates(array(
                new State('s1', true),
                new State('s2'),
                new State('s3', false, true),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t2', 's2', 's3'),
            ))
        ;

        $validator = new FsmValidator();
        $validator->validate($fsm);

        $accessor = new FsmAccessor($fsm, $validator, 'Document2', 'myState');

        $obj = new Document();
        $accessor->setInitialState($obj);

        $accessor->doTransition($obj, 't1');
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Accessor\InvalidTransitionException
     */
    public function testInvalidTransitionValue()
    {
        $accessor = $this->newAccessor();

        $obj = new Document();
        $accessor->setInitialState($obj);

        $accessor
            ->doTransition($obj, 't2')
            ->doTransition($obj, 't5')
            ->doTransition($obj, 't1')
            ->doTransition($obj, 't4')
        ;
    }

    /**
     * @expectedException \Michcald\Fsm\Exception\Accessor\TransitionNotFoundException
     */
    public function testNotFounTransitionValue()
    {
        $accessor = $this->newAccessor();

        $obj = new Document();
        $accessor->setInitialState($obj);

        $accessor
            ->doTransition($obj, 't2')
            ->doTransition($obj, 't8')
            ->doTransition($obj, 't1')
            ->doTransition($obj, 't4')
        ;
    }

    public function testGoodValue()
    {
        $accessor = $this->newAccessor();

        $obj = new Document();
        $accessor->setInitialState($obj);

        $accessor
            ->doTransition($obj, 't2')
            ->doTransition($obj, 't3')
            ->doTransition($obj, 't1')
            ->doTransition($obj, 't4')
        ;

        $this->assertTrue($accessor->isFinalState($obj));
        $this->assertFalse($accessor->isInitialState($obj));
    }

    private function newAccessor()
    {
        $fsm = new Fsm('my_fsm');
        $fsm
            ->setStates(array(
                new State('s1', true, true),
                new State('s2'),
                new State('s3'),
                new State('s4', false, true),
                new State('s5', false, true),
            ))
            ->setTransitions(array(
                new Transition('t1', 's1', 's2'),
                new Transition('t2', 's1', 's3'),
                new Transition('t3', 's3', 's1'),
                new Transition('t4', 's2', 's4'),
                new Transition('t5', 's2', 's5'),
            ))
        ;

        $validator = new FsmValidator();
        $validator
            ->addAssert(new Assert\NoDuplicateStatesAssert())
            ->addAssert(new Assert\NoDuplicateTransitionNamesAssert)
            ->addAssert(new Assert\NoTransitionWithUndefinedStatesAssert())
            ->addAssert(new Assert\OneInitialStateAssert())
        ;
        $validator->validate($fsm);

        return new FsmAccessor($fsm, $validator, 'Document', 'myState');
    }
}

class Document implements \Michcald\Fsm\Stateful\StatefulInterface
{
    private $myState;

    public function setMyState($myState)
    {
        $this->myState = $myState;

        return $this;
    }

    public function getMyState()
    {
        return $this->myState;
    }
}