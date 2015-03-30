<?php

namespace Michcald\Fsm\Validator;

use Michcald\Fsm\Model\Fsm;

interface ValidatorInterface
{
    public function validate(Fsm $fsm, $throwExceptions = true);
}
