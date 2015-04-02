<?php

namespace Michcald\Fsm\Exception\Accessor;

use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Accessor\AccessorInterface;

class InvalidStatefulPropertyException extends \Exception
{
    public function __construct(FsmInterface $fsm, AccessorInterface $accessor, $code = 0, $previous = null)
    {
        $message = sprintf(
            'FSM <%s>: Stateful class <%s> must have access methods for property <%s>',
            $fsm->getName(),
            $accessor->getObjectClass(),
            $accessor->getObjectProperty()
        );

        parent::__construct($message, $code, $previous);
    }
}
