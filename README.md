# FSM

A Finite State Machine (FSM) implementation for PHP.

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

## The Stateful Entity

We define a *Stateful Entity* as a particular class in our business domain that has a property whose value can change depending by a given FSM schema.

For Doctrine users, this will be a normal Doctrine entity with a property with any particular type (as long as the type is pertinent with what the value will be).

The Stateful Entity MUST implement the following interface:

```php
use Michcald\Fsm\Stateful\StatefulInterface;
```

This library supports multiple properties related to mulitple FSMs for the same Stateful Entity.

```php
use Michcald\Fsm\Stateful\StatefulInterface;

class Document implements StatefulInterface
{
    private $state1;

    private $state2;
}
```

## The Model

The model consists in the base classes for creating a FSM (FSM, states and transitions).

```php
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Model\Interfaces\StateInterface;

$fsm = new Fsm('fsm1');

$fsm
    ->setStates(array(
        // new State($stateName, $isInitial = false, $isFinal = false)
        new State('s1', true), // initial state
        new State('s2'),
        new State('s3'),
        new State('s4', false, true), // final state
    ))
    ->setTransitions(array(
        // new Transition($transitionName, $fromStateName, $toStateName)
        new Transition('t1', 's1', 's2'),
        new Transition('t2', 's1', 's3'),
        new Transition('t3', 's3', 's1'),
        new Transition('t4', 's2', 's4'),
    ))
;
```

## The FSMValidator

This component is really important as it is in charge of validating the FSM.

This library does not define a specific validation for the FSM but provides few basic assert classes that can be added to the validator.

An *Alert Class* is a class whose task is to validate a specific assert for the FSM (e.g. if the FSM requires an initial state).

The validator can contain as many asserts as you want. You can also create your owns as long as they implement the following interface:

```php
use Michcald\Fsm\Validator\Assert\AssertInterface;
```

It's a good idea to create at least one new exception types for every Assert.


```php
// $fsm variable as defined above

use Michcald\Fsm\Validator\FsmValidator;
use Michcald\Fsm\Validator\Assert;

// instanciating the validator
$validator = new FsmValidator();

// adding asserts to the validator
$validator
    ->addAssert(new Assert\OneInitialStateAssert())
    ->addAssert(new Assert\NoDuplicateStatesAssert())
    ->addAssert(new Assert\NoDuplicateTransitionNamesAssert())
    ->addAssert(new Assert\NoTransitionWithUndefinedStatesAssert())
;

// validating without throwing exceptions
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

You can easily create your own assert. Here an example that does not allow the initial state to be a final state at the same time:

```php
namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

class InitialStateCannotBeAlsoFinalAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm, $throwExceptions = true)
    {
        try {
            $count = 0;
            foreach ($fsm->getStates() as $state) {
                if ($state->getIsInitial() && $state->getIsFinal()) {
                    throw new Exception\InitialStateCannotBeAlsoFinalException($fsm, $state);
                }
            }
            return true;
        } catch (\Exception $e) {
            if ($throwExceptions) {
                throw $e;
            } else {
                return false;
            }
        }
    }
}
```

## The Accessor

The model component just defines the FSM's schema but it does not include any logic to change the state of a Stateful Entity.

In order to execute transitions you need to use the Accessor component. 

Every FSM requires at least one Accessor.

The Accessor class requires:
* the FSM object
* the validator object
* the Stateful class name
* the Stateful class property that will contain the value of the current state. The class must provide the proper setter/getter `set{PropertyName}($value)` and `get{PropertyName}()`.

The Accessor is in charge of:

* using the validator to validate the FSM schema before every operation
* initializing the state of your Stateful entity
* change the state of your Stateful entity executing a transition

Getting back to the Stateful Entity:

```php
namespace Whatever\Entity;

use Michcald\Fsm\Stateful\StatefulInterface;

class Document implements StatefulInterface
{
    private $state;

    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }
}
```

We then create the accessor object and move the Stateful entity across transitions.

```php
use Michcald\Fsm\Accessor\FsmAccessor;
use Michcald\Fsm\Validator\FsmValidator;

// $fsm variable as defined above

$accessor = new DirectAccessor(
    $fsm,                         // the FSM
    new FsmValidator(),           // the FSM validator
    '\Whatever\Entity\Document',  // the class name
    'state'                       // the class property (this implies that the class has defined the methods setState() and getState())
);

$doc = new \Whatever\Entity\Document();

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
* the asserts - implementing `Michcald\Fsm\Validator\Assert\AssertInterface`

## Examples

You can find working examples in the `examples` folder.

