<?php

namespace Michcald\Fsm\Exception;

use Michcald\Fsm\Accessor\AccessorInterface;

class InvalidObjectForAccessorException extends \Exception
{
    public function __construct(AccessorInterface $accessor, FsmInterface $object, $code = 0, $previous = null)
    {
        $message = sprintf(
            'Accessor of class <%s> expects an object of class <%s>. <%s> provided.',
            get_class($accessor),
            $accessor->getExpectedObjectInterface(),
            get_class($object)
        );

        parent::__construct($message, $code, $previous);
    }
}
