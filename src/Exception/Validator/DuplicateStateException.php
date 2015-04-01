<?php

namespace Michcald\Fsm\Exception\Validator;

use Michcald\Fsm\Model\Fsm;

class DuplicateStateException extends \Exception
{
    public function __construct(Fsm $fsm, $stateName, $code = 0, $previous = null)
    {
        $message = sprintf(
            'State <%s> is already used in FSM <%s>',
            $stateName,
            $fsm->getName()
        );

        parent::__construct($message, $code, $previous);
    }
}
