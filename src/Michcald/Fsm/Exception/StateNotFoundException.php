<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;

class StateNotFoundException extends \Exception
{
    public function __construct(Fsm $fsm, $stateName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'State <%s> not found in FSM <%s>',
            $stateName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
