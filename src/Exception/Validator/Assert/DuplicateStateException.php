<?php

namespace Michcald\Fsm\Exception\Validator\Assert;

use Michcald\Fsm\Model\Interfaces\FsmInterface;

class DuplicateStateException extends \Exception
{
    public function __construct(FsmInterface $fsm, $stateName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'State <%s> is already used in FSM <%s>',
            $stateName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
