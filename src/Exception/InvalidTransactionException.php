<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmTransaction;

class InvalidTransactionException extends \Exception
{
    public function __construct(Fsm $fsm, FsmTransaction $transaction, $currentState, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Invalid transaction <%s> from state <%s> to state <%s> on current state <%s> for FSM <%s>',
            $transaction->getName(),
            $transaction->getFromStateName(),
            $transaction->getToStateName(),
            $currentState,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
