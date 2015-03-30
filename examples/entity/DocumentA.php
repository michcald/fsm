<?php

use Michcald\Fsm\Stateful\StatefulDirectInterface;

class DocumentA implements StatefulDirectInterface
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
