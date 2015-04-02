<?php

namespace Michcald\Fsm\Exception\Accessor;

use Michcald\Fsm\Model\Interfaces\FsmInterface;

class TransitionNotFoundException extends \Exception
{
    public function __construct(FsmInterface $fsm, $transitionName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Transition <%s> not found in FSM <%s>',
            $transitionName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
