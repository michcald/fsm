<?php

require __DIR__ . '/../vendor/autoload.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;

$fsm = new Fsm('fsm1');
$fsm
    ->setStates(array(
        new State('s1', true),
        new State('s2'),
        new State('s3'),
        new State('s4', false, true),
    ))
    ->setTransitions(array(
        new Transition('t1', 's1', 's2'),
        new Transition('t2', 's1', 's3'),
        new Transition('t3', 's3', 's1'),
        new Transition('t4', 's2', 's4'),
    ))
;

printf('# FSM <%s>%s', $fsm->getName(), PHP_EOL);

printf('%s', PHP_EOL);

printf('# States%s', PHP_EOL);
foreach ($fsm->getStates() as $state) {
    printf(
        "State <%s> of type <%s>%s",
        $state->getName(),
        $state->getIsInitial() ? 'INITIAL' : ($state->getIsFinal() ? 'FINAL' : 'NORMAL'),
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
