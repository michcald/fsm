<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Interfaces\FsmInterface;

interface AccessorInterface
{
    public function doTransaction(FsmInterface $object, $transactionName);

    public function getExpectedObjectInterface();
}
