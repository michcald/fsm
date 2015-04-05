<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Stateful\StatefulInterface;
use Michcald\Fsm\Validator\ValidatorInterface;

interface AccessorInterface
{
    public function setFsm(Fsm $fsm);

    public function setObjectClass($objectClass);

    public function getObjectClass();

    public function setObjectProperty($objectProperty);

    public function getObjectProperty();

    public function setValidator(ValidatorInterface $validator);

    public function doTransition(StatefulInterface $object, $transitionName);

    public function isInitialState(StatefulInterface $object);

    public function isFinalState(StatefulInterface $object);
}
