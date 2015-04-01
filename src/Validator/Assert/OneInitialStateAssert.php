<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\Interfaces\StateInterface;

/**
 * OneInitialStateAssert
 *
 * The FSM MUST have an initial state
 */
class OneInitialStateAssert implements ValidatorInterface
{
    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {
            $initialStatesCount = $fsm->countStatesByType(StateInterface::TYPE_INITIAL);
            if ($initialStatesCount == 0) {
                throw new Exception\MissingInitialStateException($fsm);
            }
            if ($initialStatesCount > 1) {
                throw new Exception\MultipleInitialStatesException($fsm);
            }
            return true;
        } catch (\Exception $e) {
            if ($throwExceptions) {
                throw $e;
            } else {
                return false;
            }
        }
    }
}
