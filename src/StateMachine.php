<?php

declare(strict_types=1);

namespace App;

class StateMachine
{
    public function __construct(private array $transitions)
    {
    }

    /**
     * Check if we are allowed to apply $state right now. Ie, is there an transition
     * from $this->state to $state?
     */
    public function can(StateAwareInterface $stateAwareObject, string $transition): bool
    {
        return in_array($transition, $this->getValidTransitions($stateAwareObject));
    }

    /**
     * @throws \InvalidArgumentException if the $newState is invalid.
     */
    public function apply(StateAwareInterface $stateAwareObject, string $transition): void
    {
        if (!$this->can($stateAwareObject, $transition)) {
            throw new \InvalidArgumentException("Invalid transition '$transition'.");
        }

        $transitionsForCurrentState = $this->transitions[$stateAwareObject->getState()];

        $stateAwareObject->setState($transitionsForCurrentState[$transition]);
    }

    public function getCurrentState(StateAwareInterface $stateAwareObject): string
    {
        return $stateAwareObject->getState();
    }

    public function getValidTransitions(StateAwareInterface $stateAwareObject): array
    {
        $transitionsForCurrentState = $this->transitions[$stateAwareObject->getState()];

        return array_keys($transitionsForCurrentState);
    }
}
