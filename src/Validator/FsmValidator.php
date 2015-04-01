<?php

namespace Michcald\Fsm\Validator;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;

class FsmValidator implements ValidatorInterface
{
    private $asserts = array();

    public function addAssert(ValidatorInterface $assert)
    {
        $this->asserts[] = $assert;

        return $this;
    }

    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {
            foreach ($this->asserts as $assert) {
                $assert->validate($fsm, $throwExceptions);
            }
            return true;
        } catch (\Exception $e) {
            if ($throwExceptions) {
                throw $e;
            } else {
                return false;
            }
        }

        return true;
    }
}
