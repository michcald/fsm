<?php

namespace Michcald\Fsm\Validator;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Validator\Assert\AssertInterface;

class FsmValidator implements ValidatorInterface
{
    private $asserts = array();

    public function addAssert(AssertInterface $assert)
    {
        $this->asserts[] = $assert;

        return $this;
    }

    public function validate(FsmInterface $fsm)
    {
        foreach ($this->asserts as $assert) {
            $assert->validate($fsm);
        }
    }
}
