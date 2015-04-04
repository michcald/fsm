<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Model\Interfaces\FsmInterface;

interface AssertInterface
{
    public function validate(FsmInterface $fsm);
}
