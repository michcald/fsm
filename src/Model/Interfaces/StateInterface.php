<?php

namespace Michcald\Fsm\Model\Interfaces;

interface StateInterface
{
    const TYPE_NORMAL = 'normal';

    const TYPE_INITIAL = 'initial';

    const TYPE_FINAL = 'final';

    public function setType($type);

    public function getType();
}
