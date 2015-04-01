<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\Interfaces\StateInterface;

/**
 * TransitionNamesDuplicatesAssert
 *
 * There MUST NOT be transitions with the same name starting from the same state
 */
class TransitionNamesDuplicatesAssert implements ValidatorInterface
{
    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {
            // @todo
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
