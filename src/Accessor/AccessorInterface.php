<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Stateful\StatefulInterface;

interface AccessorInterface
{
    public function setInitialState(StatefulInterface $object);

    public function doTransition(StatefulInterface $object, $transitionName);

    public function isInitialState(StatefulInterface $object);

    public function isFinalState(StatefulInterface $object);

    public function getExpectedObjectInterface();
}
