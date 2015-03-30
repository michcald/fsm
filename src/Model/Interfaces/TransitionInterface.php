<?php

namespace Michcald\Fsm\Model\Interfaces;

interface TransitionInterface extends NameableInterface
{
    public function setFromStateName($fromStateName);

    public function getFromStateName();

    public function setToStateName($toStateName);

    public function getToStateName();
}
