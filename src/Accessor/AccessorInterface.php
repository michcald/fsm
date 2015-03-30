<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Interfaces\FsmInterface;

interface AccessorInterface
{
    public function doTransition(FsmInterface $object, $transitionName);

    public function isInStartState(FsmInterface $object);

    public function isInEndState(FsmInterface $object);

    public function getExpectedObjectInterface();
}
