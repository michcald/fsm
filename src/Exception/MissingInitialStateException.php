<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;

class MissingInitialStateException extends \Exception
{
    public function __construct(Fsm $fsm, $code = 0, $previous = null)
    {
        $message = sprintf(
            'FSM <%s> must have an initial state',
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
