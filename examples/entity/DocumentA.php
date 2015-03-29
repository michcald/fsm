<?php

use Michcald\Fsm\Interfaces\FsmDirectInterface;

class DocumentA implements FsmDirectInterface
{
    private $myState;

    public function setMyState($state)
    {
        $this->myState = $state;

        return $this;
    }

    public function getMyState()
    {
        return $this->myState;
    }
}
