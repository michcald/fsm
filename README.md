# FSM

A Finite State Machine library (FSM) implementation for PHP.

Supports multiple FSMs for the same entity.

# Getting started

## Installation (using composer)
You can find the library in packagist [here](https://packagist.org/packages/michcald/fsm).
```
{
  "require": {
    "michcald/fsm": "dev-master"
  }
}
```

## Components

The library works with these main components:

### The Model

The model consists in the base classes for creating a FSM (states, transactions).

```php
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransaction;

// defining all the states
$s1 = new FsmState('s1', FsmState::TYPE_START);
$s2 = new FsmState('s2', FsmState::TYPE_NORMAL);
$s3 = new FsmState('s3');
$s4 = new FsmState('s4', FsmState::TYPE_END);

// defining all the transactions
$t1 = new FsmTransaction('t1', 's1', 's2');
$t2 = new FsmTransaction('t2', 's1', 's3');
$t3 = new FsmTransaction('t3', 's3', 's1');
$t4 = new FsmTransaction('t4', 's2', 's4');

// initializing the FSM
$fsm = new Fsm('fsm1');

$fsm->addState($s1);
$fsm->addState($s2);
$fsm->addState($s3);
$fsm->addState($s4);

$fsm->addTransaction($t1);
$fsm->addTransaction($t2);
$fsm->addTransaction($t3);
$fsm->addTransaction($t4);
```

### The FSM Validator

This component is in charge of validating the FSM after being populated with states and transactions.

You can decide to validate using exceptions or not just passing an optional parameter to the `validate($object, $throwExceptions = true)` method.

```php
$fsm = // the FSM generated above

use Michcald\Fsm\Validator\FsmValidator;

// validating the FSM
$validator = new FsmValidator();

// validating without throwing exceptions (the default behaviour does)
$isValid = $validator->validate($fsm, false);

if ($isValid) {
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} else {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}

// adding an invalid transaction
$fsm->addTransaction(new FsmTransaction('t1', 's1', 's2'));

// validating throwing exceptions
try {
    $validator->validate($fsm);
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} catch (\Exception $e) {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}
```

### The Application Entity and the FSM Accessor

The Application Entity is the model class in your application that will be binded to one or more FSM(s).

You will never use the FSM model straight away, but you will use an accessor class instead.

There are two ways to hook a FSM in your Application Entity:
* using a `DirectAccessor`, or
* using an `IndirectAccessor`

#### The two accessor ways

There is not a best way here, just choose what you prefer.

##### The DirectAccessor

This method allows you to define which setter/getter your Application Entity is using in order to map the property that contains the current state.

First we define our Application Entity implementing the `FsmDirectInterface` interface.

```php
namespace Whatever\Entity;

use Michcald\Fsm\Interfaces\FsmDirectInterface;

class DocumentA implements FsmDirectInterface
{
    private $myState;

    public function setMyState($state)
    {
        $this->myState = $state;

        return $this;
    }

    public function getMyState()
    {
        return $this->myState;
    }
}
```

After instanciating the class we do the same for the `DirectAccessor` injecting also the setter and getter methods.

```php
$doc = new DocumentA();
$doc->setMyState('s1'); // initializing the entry point

$accessor = new DirectAccessor(
    $fsm,                         // the FSM
    '\Whatever\Entity\DocumentA', // the class name
    new FsmValidator(),           // the FSM validator
    'setMyState',                 // the setter method
    'getMyState'                  // the getter method
);
```

##### The IndirectAccessor

This method provides a standard interface in order to access it your Application Entity to the property that contains the current state.

Here, instead, we implement the `FmsIndirectInterface` and we are required to implement the `getFsmState()` and `setFsmState()` methods. These methods work as routers to the real class property.

```php
namespace Whatever\Entity;

use Michcald\Fsm\Interfaces\FsmIndirectInterface;

class DocumentB implements FsmIndirectInterface
{
    private $myState1;

    private $myState2;

    public function getFsmState($fsmName)
    {
        switch ($fsmName) {
            case 'fsm1':
                return $this->myState1;
            case 'fsm2':
                return $this->myState2;
        }
    }

    public function setFsmState($fsmName, $stateName)
    {
        switch ($fsmName) {
            case 'fsm1':
                $this->myState1 = $stateName;
                break;
            case 'fsm2':
                $this->myState2 = $stateName;
                break;
        }
    }
}
```

Using the `FsmIndirectInterface` does not require to inject any extra arguments in the accessor object.

```php
$doc = new DocumentB();
$doc->setFsmState('fsm1', 's1'); // initializing the entry point

$accessor = new IndirectAccessor(
    $fsm,                         // the FSM
    '\Whatever\Entity\DocumentB', // the class name
    new FsmValidator()            // the FSM validator
);
```

#### Accessing the FSM and executing transactions

```php

// ... defining the FSM

// ... defining the application entity (direct or indirect)
$doc = new DocumentY();
$doc->setMyState('s1'); // initial state

// ... defining the accessor (direct or indirect)

if ($accessor->isInStartState($doc)) {
  printf('The object is in the START state%s', PHP_EOL);
}

$accessor->doTransaction($doc, 't1');
$accessor->doTransaction($doc, 't4');

if ($accessor->isInEndState($doc)) {
  printf('The object has reached an END state%s', PHP_EOL);
}
```


## Customization

You can easily define your customized Accessor extending the class `Michcald\Fsm\Accessor\AccessorAbstract`.

Same thing for the validator implementing `Michcald\Fsm\Validator\ValidatorInterface`.

## Examples

You can find working examples in the `examples` folder.

# Keep in touch

Any questions, suggestions, pull reqs, etc. will be appreciated.
