# FSM

A Finite State Machine library (FSM) implementation for PHP.

Supports multiple FSMs for the same entity.

**WARNING:** this package is close to a stable release. Stay tuned!

# Installation (using composer)
You can find the library in packagist [here](https://packagist.org/packages/michcald/fsm).
```
{
  "require": {
    "michcald/fsm": "dev-master"
  }
}
```

# Components

The library works with these main components:

## The Model

The model consists in the base classes for creating a FSM (states, transitions).

```php
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Model\Interfaces\StateInterface;

// defining all the states
$s1 = new State('s1', StateInterface::TYPE_INITIAL);
$s2 = new State('s2', StateInterface::TYPE_NORMAL);
$s3 = new State('s3');
$s4 = new State('s4', StateInterface::TYPE_FINAL);

// defining all the transitions
$t1 = new Transition('t1', 's1', 's2');
$t2 = new Transition('t2', 's1', 's3');
$t3 = new Transition('t3', 's3', 's1');
$t4 = new Transition('t4', 's2', 's4');

// initializing the FSM
$fsm = new Fsm('fsm1');

$fsm->addState($s1);
$fsm->addState($s2);
$fsm->addState($s3);
$fsm->addState($s4);

$fsm->addTransition($t1);
$fsm->addTransition($t2);
$fsm->addTransition($t3);
$fsm->addTransition($t4);
```

## The FSM Validator

This component is in charge of validating the FSM after being populated with states and transitions.

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

// adding an invalid transition
$fsm->addTransition(new FsmTransition('t1', 's1', 's2'));

// validating throwing exceptions
try {
    $validator->validate($fsm);
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} catch (\Exception $e) {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}
```

## The Stateful model

This is the class in your application that will hold the state related to a FSM.

## The Accessor

The model components above do not implement any workflow logic. They just define the structure of the FSM.

In order to execute transitions you need to use the Accessor class. 

Every FSM requires at least one Accessor.

The Accessor is in charge of changing of:
* using the validator to validate the FSM schema before every operation
* initializing the state of your object
* change the state of your object executing a transition

First we define the class implementing the `StatefulInterface` interface.

```php
namespace Whatever\Entity;

use Michcald\Fsm\Stateful\StatefulInterface;

class Document implements StatefulInterface
{
    private $myState;

    public function setMyState($myState)
    {
        $this->myState = $myState;

        return $this;
    }

    public function getMyState()
    {
        return $this->myState;
    }
}
```

We then create the accessor object and use the FSM.

```php
$fsm = ...;

$accessor = new DirectAccessor(
    $fsm,                         // the FSM
    new FsmValidator(),           // the FSM validator
    '\Whatever\Entity\Document',  // the class name
    'myState'                     // the class property (this implies that the class has defined the methods setMyState() and getMyState())
);

$doc = new Document();

// initializing the entry point (every FSM must have one initial state)
$accessor->setInitialState($doc);

if ($accessor->isInitialState($doc)) {
  printf('The object is in the INITIAL state%s', PHP_EOL);
}

$accessor->doTransition($doc, 't1');
$accessor->doTransition($doc, 't4');

if ($accessor->isFinalState($doc)) {
  printf('The object has reached a FINAL state%s', PHP_EOL);
}
```

## Customization

You can easily customize every single components:

* the models
  * the FSM class - implementing `Michcald\Fsm\Model\Interfaces\FsmInterface`
  * the State class - implementing `Michcald\Fsm\Model\Interfaces\StateInterface`
  * the Transition class - implementing `Michcald\Fsm\Model\Interfaces\TransitionInterface`
* the accessor - implementing `Michcald\Fsm\Accessor\AccessorInterface`
* the validator - implementing `Michcald\Fsm\Validator\ValidatorInterface`

## Examples

You can find working examples in the `examples` folder.

# Keep in touch

Any questions, suggestions, pull reqs, etc. will be appreciated.
