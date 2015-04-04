<?php

namespace Michcald\Fsm\Validator;

use Michcald\Fsm\Model\Interfaces\FsmInterface;

interface ValidatorInterface
{
    public function validate(FsmInterface $fsm);
}
