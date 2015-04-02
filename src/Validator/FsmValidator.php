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

    public function validate(FsmInterface $fsm, $throwExceptions = true)
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
