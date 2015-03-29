<?php

namespace Michcald\Fsm\Validator;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Exception;

class FsmValidator
{
    /**
     * validate
     * 
     * @param Fsm $fsm
     * @return boolean
     * @throws Exception\DuplicateStateException
     * @throws Exception\MissingStartStateException
     * @throws Exception\MultipleStartStatesException
     * @throws Exception\DuplicateTransactionException
     * @throws Exception\StateNotFoundException
     */
    public function validate(Fsm $fsm)
    {
        // every state must have a unique name
        $statesNames = array();
        foreach ($fsm->getStates() as $state) {
            $statesNames[] = $state->getName();
        }

        $duplicateStates = $this->getDuplicates($statesNames);
        foreach ($duplicateStates as $duplicateState) {
            throw new Exception\DuplicateStateException($fsm, $duplicateState);
        }

        // must have a single starting state
        $countStartStates = 0;
        foreach ($fsm->getStates() as $state) {
            if ($state->getType() == FsmState::TYPE_START) {
                $countStartStates ++;
            }
        }

        if ($countStartStates == 0) {
            throw new Exception\MissingStartStateException($fsm);
        }

        if ($countStartStates > 1) {
            throw new Exception\MultipleStartStatesException($fsm);
        }

        // every transation must have a unique name
        $transactionsNames = array();
        foreach ($fsm->getTransactions() as $transaction) {
            $transactionsNames[] = $transaction->getName();
        }

        $duplicateTransactions = $this->getDuplicates($transactionsNames);
        foreach ($duplicateTransactions as $duplicateTransaction) {
            throw new Exception\DuplicateTransactionException($fsm, $duplicateTransaction);
        }

        // every transaction from/to state must exist
        foreach ($fsm->getTransactions() as $transaction) {
            if (!$fsm->hasStateByName($transaction->getFromStateName())) {
                throw new Exception\StateNotFoundException($fsm, $transaction->getFromStateName());
            }
            if (!$fsm->hasStateByName($transaction->getToStateName())) {
                throw new Exception\StateNotFoundException($fsm, $transaction->getToStateName());
            }
        }

        return true;
    }

    private function getDuplicates(array $arr)
    {
        $dups = array();
        foreach(array_count_values($arr) as $val => $c) {
            if($c > 1) {
                $dups[] = $val;
            }
        }
        return $dups;
    }
}
