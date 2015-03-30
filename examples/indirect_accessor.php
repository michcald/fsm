<?php

require __DIR__ . '/../vendor/autoload.php';
// defining the entity that uses the FSM
include __DIR__ . '/entity/DocumentB.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransition;
use Michcald\Fsm\Accessor\IndirectAccessor;
use Michcald\Fsm\Validator\FsmValidator;

// definig the FSM
$fsm = new Fsm('fsm1');

$fsm->setStates(array(
    new FsmState('s1', FsmState::TYPE_START),
    new FsmState('s2', FsmState::TYPE_NORMAL),
    new FsmState('s3'),
    new FsmState('s4', FsmState::TYPE_END),
));

$fsm->setTransitions(array(
    new FsmTransition('t1', 's1', 's2'),
    new FsmTransition('t2', 's1', 's3'),
    new FsmTransition('t3', 's3', 's1'),
    new FsmTransition('t4', 's2', 's4'),
));

$doc = new DocumentB();
$doc->setFsmState('fsm1', 's1'); // initializing the entry point

$accessor = new IndirectAccessor(
    $fsm,               // the FSM
    'DocumentB',        // the class name
    new FsmValidator()  // the FSM validator
);

try {
    if ($accessor->isInStartState($doc)) {
        printf('The object is in the START state%s', PHP_EOL);
    }

    $accessor->doTransition($doc, 't1');
    printTransition($fsm->getTransitionByName('t1'));

    $accessor->doTransition($doc, 't4');
    printTransition($fsm->getTransitionByName('t2'));

    if ($accessor->isInEndState($doc)) {
        printf('The object has reached an END state%s', PHP_EOL);
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
