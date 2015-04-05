# FSM

A [Finite State Machine](http://en.wikipedia.org/wiki/Finite-state_machine) (FSM) implementation for PHP.

You can use this library for creating:
* [DFA](http://en.wikipedia.org/wiki/Deterministic_finite_automaton) - Deterministic Finite Automaton
* [NFA](http://en.wikipedia.org/wiki/Nondeterministic_finite_automaton) - Nondeterministic Finite Automaton

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

We define a *Stateful Entity* as a particular class in your business domain that has a property which value can change depending by a given FSM schema.

For Doctrine users this will be a normal Doctrine entity having a property of any type.

The *Stateful Entity* MUST implement the following interface:

```php
use Michcald\Fsm\Stateful\StatefulInterface;

class Document implements StatefulInterface
{
    // this property will contain the current state of the entity
    private $state;
}
```

### Multiple FMSs for the same Stateful Entity

Sometimes you can find yourself in a situation where your *Stateful Entity* might have more than one states related to different FSMs. In this case just add a new property and specify it when instanciating the accessor for the proper FSM (see below).

## The Model

The model consists in the base classes for creating a FSM (FSM, states and transitions). No restrictions are applied at this step, every is allowed, this means that no validation check is performed yet.

```php
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Transition;
use Michcald\Fsm\Model\Interfaces\StateInterface;

$fsm = new Fsm('my_fsm');

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

You can also add new states/transitions using the methods `addState($state)` and `addTransition($transition)`.

## The Validator

This component is really important as it is in charge of validating the FSM schema.

### Asserts

The default validator itself does not validate anything, but is a container of asserts. 

Every Assert class is supposed to validate a specific assert for the FSM.

The validator task is to go through all of the asserts and validate them (e.g. if the FSM can have a single initial state).

The library provides some basic asserts that you can use, but you can create your owns, as long as they implement the following interface:

```php
use Michcald\Fsm\Validator\Assert\AssertInterface;
```

It's a good idea to create at least one new exception type for every Assert class.


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

// adding an invalid transition
$fsm->addTransition(new FsmTransition('t1', 's1', 's2'));

try {
    $validator->validate($fsm);
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} catch (\Exception $e) {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}
```

You can easily create your own assert. Here is an example that does not allow the initial state to be a final state at the same time:

```php
namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

class InitialStateCannotBeAlsoFinalAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm)
    {
        $count = 0;
        foreach ($fsm->getStates() as $state) {
            if ($state->getIsInitial() && $state->getIsFinal()) {
                throw new Exception\InitialStateCannotBeAlsoFinalException($fsm, $state);
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

