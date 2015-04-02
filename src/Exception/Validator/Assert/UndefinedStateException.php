<?php

namespace Michcald\Fsm\Exception\Validator\Assert;

use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Model\Interfaces\TransitionInterface;

class UndefinedStateException extends \Exception
{
    public function __construct(FsmInterface $fsm, TransitionInterface $transition, $stateName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Cannot find state <%s> for FSM <%s> used in transition <%s>',
            $stateName,
            $fsm->getName(),
            $transition->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
