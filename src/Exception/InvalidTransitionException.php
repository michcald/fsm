<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmTransition;

class InvalidTransitionException extends \Exception
{
    public function __construct(Fsm $fsm, FsmTransition $transition, $currentState, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Invalid transition <%s> from state <%s> to state <%s> on current state <%s> for FSM <%s>',
            $transition->getName(),
            $transition->getFromStateName(),
            $transition->getToStateName(),
            $currentState,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
