<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;

/**
 * DfaAssert
 *
 * Assert for a DFA (Deterministic Finite Automaton) machine.
 * See here http://en.wikipedia.org/wiki/Deterministic_finite_automaton
 */
class DfaAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm)
    {
        $v1 = new NoDuplicateStatesAssert();
        $v1->validate($fsm);

        $v2 = new NoDuplicateTransitionNamesAssert();
        $v2->validate($fsm);

        $v3 = new NoTransitionWithUndefinedStatesAssert();
        $v3->validate($fsm);

        $v4 = new OneInitialStateAssert();
        $v4->validate($fsm);
    }
}
