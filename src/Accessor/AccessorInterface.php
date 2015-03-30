<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Interfaces\FsmInterface;

interface AccessorInterface
{
    public function doTransition(FsmInterface $object, $transitionName);

    public function isInitialState(FsmInterface $object);

    public function isFinalState(FsmInterface $object);

    public function getExpectedObjectInterface();
}
