<?php

require __DIR__ . '/../vendor/autoload.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransaction;

$states = array(
    new FsmState('s1', FsmState::TYPE_START),
    new FsmState('s2', FsmState::TYPE_NORMAL),
    new FsmState('s3'),
    new FsmState('s4', FsmState::TYPE_END),
);

$transactions = array(
    new FsmTransaction('t1', 's1', 's2'),
    new FsmTransaction('t2', 's1', 's3'),
    new FsmTransaction('t3', 's3', 's1'),
    new FsmTransaction('t4', 's2', 's4'),
);

$fsm = new Fsm('fsm1');
$fsm->setStates($states);
$fsm->setTransactions($transactions);

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

printf('# Transactions%s', PHP_EOL);
foreach ($fsm->getTransactions() as $transaction) {
    printf(
        "Transaction <%s> from state <%s> to state <%s>%s",
        $transaction->getName(),
        $transaction->getFromStateName(),
        $transaction->getToStateName(),
        PHP_EOL
    );
}
