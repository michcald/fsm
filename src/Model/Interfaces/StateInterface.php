<?php

namespace Michcald\Fsm\Model\Interfaces;

interface StateInterface
{
    public function setIsInitial($isInitial);

    public function getIsInitial();

    public function setIsFinal($isFinal);

    public function getIsFinal();
}
