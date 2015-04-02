<?php

require __DIR__ . '/../vendor/autoload.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Validator\FsmValidator;

// initializing the FSM
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

// validating the FSM
$validator = new FsmValidator();

$isValid = $validator->validate($fsm, false);

if ($isValid) {
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} else {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}

// or we can use exceptions

// adding an invalid transition
$fsm->addTransition(
    new Transition('t1', 's1', 's2')
);

try {
    $validator->validate($fsm);
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} catch (\Exception $e) {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}
