<?php

namespace Michcald\Fsm\Stateful;

interface StatefulIndirectInterface extends StatefulInterface
{
    public function getFsmState($fsmName);

    public function setFsmState($fsmName, $stateName);
}
