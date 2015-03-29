<?php

namespace Michcald\Fsm\Interfaces;

interface FsmIndirectInterface extends FsmInterface
{
    public function getFsmState($fsmName);

    public function setFsmState($fsmName, $stateName);
}
