<?php

namespace Michcald\Fsm\Exception\Validator\Assert;

use Michcald\Fsm\Model\Interfaces\FsmInterface;

class DuplicateTransitionException extends \Exception
{
    public function __construct(FsmInterface $fsm, $transitionName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Transition <%s> is already used in FSM <%s>',
            $transitionName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
