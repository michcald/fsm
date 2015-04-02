<?php

require __DIR__ . '/../vendor/autoload.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Stateful\StatefulInterface;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Accessor\FsmAccessor;
use Michcald\Fsm\Validator\FsmValidator;

class Document implements StatefulInterface
{
    private $myState;

    public function setMyState($state)
    {
        $this->myState = $state;

        return $this;
    }

    public function getMyState()
    {
        return $this->myState;
    }
}

// definig the FSM
$fsm = new Fsm('fsm1');

$fsm->setStates(array(
    new State('s1', true),
    new State('s2'),
    new State('s3'),
    new State('s4', false, true),
));

$fsm->setTransitions(array(
    new Transition('t1', 's1', 's2'),
    new Transition('t2', 's1', 's3'),
    new Transition('t3', 's3', 's1'),
    new Transition('t4', 's2', 's4'),
));

$doc = new Document();

$accessor = new FsmAccessor(
    $fsm,               // the FSM
    new FsmValidator(), // the FSM validator
    'Document',         // the class name
    'myState'           // the property
);

// WARNING: use the validator in the accessor before to execute any operation
// that might change the stateful object state

$accessor->setInitialState($doc);

try {
    if ($accessor->isInitialState($doc)) {
        printf('The object is in the INITIAL state%s', PHP_EOL);
    }

    $accessor->doTransition($doc, 't1');
    printTransition($fsm->getTransitionByName('t1'));

    $accessor->doTransition($doc, 't4');
    printTransition($fsm->getTransitionByName('t4'));

    if ($accessor->isFinalState($doc)) {
        printf('The object has reached an FINAL state%s', PHP_EOL);
    }
} catch (\Exception $e) {
    throw $e;
}


function printTransition(Transition $transition)
{
    printf(
        'Transition <%s> from state <%s> to state <%s> completed%s',
        $transition->getName(),
        $transition->getFromStateName(),
        $transition->getToStateName(),
        PHP_EOL
    );
}
