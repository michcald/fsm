<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;

class TransactionNotFoundException extends \Exception
{
    public function __construct(Fsm $fsm, $transactionName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Transaction <%s> not found in FSM <%s>',
            $transactionName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
