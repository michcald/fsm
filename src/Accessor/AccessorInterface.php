<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Interfaces\FsmInterface;

interface AccessorInterface
{
    public function doTransaction(FsmInterface $object, $transactionName);

    public function isInStartState(FsmInterface $object);

    public function isInEndState(FsmInterface $object);

    public function getExpectedObjectInterface();
}
