<?php

namespace Michcald\Fsm\Exception\Accessor;

use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Stateful\StatefulInterface;

class InvalidStatefulClassException extends \Exception
{
    public function __construct(FsmInterface $fsm, $expectedClass, StatefulInterface $object, $code = 0, $previous = null)
    {
        $message = sprintf(
            'FSM <%s> expects an object of class <%s>. <%s> provided.',
            $fsm->getName(),
            $expectedClass,
            get_class($object)
        );

        parent::__construct($message, $code, $previous);
    }
}
