<?php

namespace Michcald\Fsm\Model;

class FsmState
{
    const TYPE_NORMAL = 'normal';

    const TYPE_INITIAL = 'initial';

    const TYPE_FINAL = 'final';

    private $name;

    private $type;

    public function __construct($name, $type = self::TYPE_NORMAL)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
}
