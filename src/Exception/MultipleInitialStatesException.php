<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;

class MultipleInitialStatesException extends \Exception
{
    public function __construct(Fsm $fsm, $code = 0, $previous = null)
    {
        $message = sprintf(
            'FSM <%s> has multiple initial states',
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
