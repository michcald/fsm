<?php

require __DIR__ . '/../vendor/autoload.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransition;

$states = array(
    new FsmState('s1', FsmState::TYPE_START),
    new FsmState('s2', FsmState::TYPE_NORMAL),
    new FsmState('s3'),
    new FsmState('s4', FsmState::TYPE_END),
);

$transitions = array(
    new FsmTransition('t1', 's1', 's2'),
    new FsmTransition('t2', 's1', 's3'),
    new FsmTransition('t3', 's3', 's1'),
    new FsmTransition('t4', 's2', 's4'),
);

$fsm = new Fsm('fsm1');
$fsm->setStates($states);
$fsm->setTransitions($transitions);

printf('# FSM <%s>%s', $fsm->getName(), PHP_EOL);

printf('%s', PHP_EOL);

printf('# States%s', PHP_EOL);
foreach ($fsm->getStates() as $state) {
    printf(
        "State <%s> of type <%s>%s",
        $state->getName(),
        $state->getType(),
        PHP_EOL
    );
}

printf('%s', PHP_EOL);

printf('# Transitions%s', PHP_EOL);
foreach ($fsm->getTransitions() as $transition) {
    printf(
        "Transition <%s> from state <%s> to state <%s>%s",
        $transition->getName(),
        $transition->getFromStateName(),
        $transition->getToStateName(),
        PHP_EOL
    );
}
