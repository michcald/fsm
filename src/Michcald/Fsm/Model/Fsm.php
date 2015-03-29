<?php

namespace Michcald\Fsm\Model;

use Michcald\Fsm\Exception;

class Fsm
{
    /**
     * name
     *
     * @var string
     */
    private $name;

    /**
     * states
     *
     * @var array[FsmStates]
     */
    private $states;

    /**
     * transactions
     *
     * @var array[FsmTransactions]
     */
    private $transactions;

    public function __construct($name)
    {
        $this->name = $name;
        $this->states = array();
        $this->transactions = array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStates(array $states)
    {
        foreach ($states as $state) {
            $this->addState($state);
        }
        return $this;
    }

    public function hasStateByName($stateName)
    {
        foreach ($this->states as $state) {
            if ($state->getName() == $stateName) {
                return true;
            }
        }
        return false;
    }

    public function addState(FsmState $state)
    {
        if ($this->hasStateByName($state->getName())) {
            throw new Exception\DuplicateStateException($this, $state->getName());
        }

        $this->states[] = $state;

        return $this;
    }

    public function getStateByName($stateName)
    {
        foreach ($this->states as $state) {
            if ($state->getName() == $stateName) {
                return $state;
            }
        }
        return null;
    }

    public function getStates()
    {
        return $this->states;
    }

    public function setTransactions(array $transactions)
    {
        foreach ($transactions as $transaction) {
            $this->addTransaction($transaction);
        }
        return $this;
    }

    public function addTransaction(FsmTransaction $transaction)
    {
        if ($this->hasTransactionByName($transaction->getName())) {
            throw new Exception\DuplicateTransactionException($this, $transaction->getName());
        }

        if (!$this->hasStateByName($transaction->getFromStateName())) {
            throw new Exception\StateNotFoundException($this, $transaction->getFromStateName());
        }

        if (!$this->hasStateByName($transaction->getToStateName())) {
            throw new Exception\StateNotFoundException($this, $transaction->getToStateName());
        }

        $this->transactions[] = $transaction;

        return $this;
    }

    public function hasTransactionByName($transactionName)
    {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getName() == $transactionName) {
                return true;
            }
        }
        return false;
    }

    public function getTransactionByName($transactionName)
    {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getName() == $transactionName) {
                return $transaction;
            }
        }
        return null;
    }

    public function getTransactions()
    {
        return $this->transactions;
    }
}
