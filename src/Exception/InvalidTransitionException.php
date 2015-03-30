<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\Interfaces\TransitionInterface;

class InvalidTransitionException extends \Exception
{
    public function __construct(Fsm $fsm, TransitionInterface $transition, $currentStateName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Invalid transition <%s> from state <%s> to state <%s> on current state <%s> for FSM <%s>',
            $transition->getName(),
            $transition->getFromStateName(),
            $transition->getToStateName(),
            $currentStateName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
