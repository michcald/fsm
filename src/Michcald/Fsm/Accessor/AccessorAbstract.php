<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Interfaces\FsmInterface;
use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Exception;

abstract class AccessorAbstract implements AccessorInterface
{
    protected $fsm;

    protected $objectClass;

    protected $validator;

    public function __construct(Fsm $fsm, $objectClass, ValidatorInterface $validator)
    {
        $this->fsm = $fsm;
        $this->objectClass = $objectClass;
        $this->validator = $validator;
    }

    final public function doTransaction(FsmInterface $object, $transactionName)
    {
        // verifying the object class
        if (!is_a($object, $this->objectClass)) {
            throw new Exception\InvalidObjectClassException($this->fsm, $this->objectClass, $object);
        }

        // verifying the interface for the accessor
        if (!is_a($object, $this->getExpectedObjectInterface())) {
            throw new Exception\InvalidObjectForAccessorException($this, $object);
        }

        $this
            ->validator
            ->validate($this->fsm)
        ;

        $currentStateName = $this->getCurrentStateName($object);

        // verify the transaction

        $transaction = $this
            ->fsm
            ->getTransactionByName($transactionName)
        ;

        if (!$transaction) {
            throw new Exception\TransactionNotFoundException($this->fsm, $transactionName);
        }

        if ($transaction->getFromStateName() != $currentStateName) {
            throw new Exception\InvalidTransactionException($this->fsm, $transaction, $currentStateName);
        }

        // execute transaction

        $this->setCurrentStateName($object, $transaction->getToStateName());
    }

    abstract protected function getCurrentStateName(FsmInterface $object);

    abstract protected function setCurrentStateName(FsmInterface $object, $stateName);
}
