<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;

class TransitionNotFoundException extends \Exception
{
    public function __construct(Fsm $fsm, $transitionName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Transition <%s> not found in FSM <%s>',
            $transitionName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
