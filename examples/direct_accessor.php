<?php

require __DIR__ . '/../vendor/autoload.php';
// defining the entity that uses the FSM
include __DIR__ . '/entity/DocumentA.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransition;
use Michcald\Fsm\Accessor\DirectAccessor;
use Michcald\Fsm\Validator\FsmValidator;

// definig the FSM
$fsm = new Fsm('fsm1');

$fsm->setStates(array(
    new FsmState('s1', FsmState::TYPE_INITIAL),
    new FsmState('s2', FsmState::TYPE_NORMAL),
    new FsmState('s3'),
    new FsmState('s4', FsmState::TYPE_FINAL),
));

$fsm->setTransitionTransitions(array(
    new FsmTransition('t1', 's1', 's2'),
    new FsmTransition('t2', 's1', 's3'),
    new FsmTransition('t3', 's3', 's1'),
    new FsmTransition('t4', 's2', 's4'),
));

$doc = new DocumentA();
$doc->setMyState('s1'); // initializing the entry point

$accessor = new DirectAccessor(
    $fsm,               // the FSM
    'DocumentA',        // the class name
    new FsmValidator(), // the FSM validator
    'setMyState',       // the setter method
    'getMyState'        // the getter method
);

try {
    if ($accessor->isInitialState($doc)) {
        printf('The object is in the INITIAL state%s', PHP_EOL);
    }

    $accessor->doTransition($doc, 't1');
    printTransition($fsm->getTransitionByName('t1'));

    $accessor->doTransition($doc, 't4');
    printTransition($fsm->getTransitionByName('t2'));

    if ($accessor->isFinalState($doc)) {
        printf('The object has reached an FINAL state%s', PHP_EOL);
    }
} catch (\Exception $e) {
    throw $e;
}


function printTransition(FsmTransition $transition)
{
    printf(
        'Transition <%s> from state <%s> to state <%s> completed%s',
        $transition->getName(),
        $transition->getFromStateName(),
        $transition->getToStateName(),
        PHP_EOL
    );
}
