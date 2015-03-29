<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Interfaces\FsmInterface;

class InvalidObjectClassException extends \Exception
{
    public function __construct(Fsm $fsm, $expectedClass, FsmInterface $object, $code = 0, $previous = null)
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
