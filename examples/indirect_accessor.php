<?php

require __DIR__ . '/../vendor/autoload.php';
// defining the entity that uses the FSM
include __DIR__ . '/entity/DocumentB.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransaction;
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

$fsm->setTransactions(array(
    new FsmTransaction('t1', 's1', 's2'),
    new FsmTransaction('t2', 's1', 's3'),
    new FsmTransaction('t3', 's3', 's1'),
    new FsmTransaction('t4', 's2', 's4'),
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

    $accessor->doTransaction($doc, 't1');
    printTransaction($fsm->getTransactionByName('t1'));

    $accessor->doTransaction($doc, 't4');
    printTransaction($fsm->getTransactionByName('t2'));

    if ($accessor->isInEndState($doc)) {
        printf('The object has reached an END state%s', PHP_EOL);
    }
} catch (\Exception $e) {
    throw $e;
}


function printTransaction(FsmTransaction $transaction)
{
    printf(
        'Transaction <%s> from state <%s> to state <%s> completed%s',
        $transaction->getName(),
        $transaction->getFromStateName(),
        $transaction->getToStateName(),
        PHP_EOL
    );
}
