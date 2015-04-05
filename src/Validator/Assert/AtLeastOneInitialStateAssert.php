<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

/**
 * AtLeastOneInitialStateAssert
 *
 * The FSM MUST have an initial state
 */
class AtLeastOneInitialStateAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm)
    {
        $count = count($fsm->getInitialStates());

        if ($count == 0) {
            throw new Exception\MissingInitialStateException($fsm);
        }
    }
}
