<?php

use Michcald\Fsm\Interfaces\FsmIndirectInterface;

class DocumentB implements FsmIndirectInterface
{
    private $myState1;

    private $myState2;

    public function getFsmState($fsmName)
    {
        switch ($fsmName) {
            case 'fsm1':
                return $this->myState1;
            case 'fsm2':
                return $this->myState2;
        }
    }

    public function setFsmState($fsmName, $stateName)
    {
        switch ($fsmName) {
            case 'fsm1':
                $this->myState1 = $stateName;
                break;
            case 'fsm2':
                $this->myState2 = $stateName;
                break;
        }
    }
}
