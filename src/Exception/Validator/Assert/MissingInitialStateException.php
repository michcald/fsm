<?php

namespace Michcald\Fsm\Exception\Validator\Assert;

use Michcald\Fsm\Model\Interfaces\FsmInterface;

class MissingInitialStateException extends \Exception
{
    public function __construct(FsmInterface $fsm, $code = 0, $previous = null)
    {
        $message = sprintf(
            'FSM <%s> must have an initial state',
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
