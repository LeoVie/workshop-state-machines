<?php

declare(strict_types=1);

namespace App;

class TrafficLightStateMachine
{
    public const GREEN = 'green';
    public const YELLOW = 'yellow';
    public const RED = 'red';

    public const TO_YELLOW = 'to_yellow';
    public const TO_GREEN = 'to_green';
    public const TO_RED = 'to_red';

    /** @var string State. (Exercise 1) This variable name is used in tests. Do not rename.  */
    private $state;

    /**
     * Check if we are allowed to apply $state right now. Ie, is there an transition
     * from $this->state to $state?
     */
    public function can(string $transition): bool
    {
        if ($this->state === self::GREEN) {
            return $transition === self::TO_YELLOW;
        }

        if ($this->state === self::YELLOW) {
            return $transition === self::TO_GREEN
                || $transition === self::TO_RED;
        }

        if ($this->state === self::RED) {
            return $transition === self::TO_YELLOW;
        }

        return false;
    }

    /**
     * This will update $this->state.
     *
     * @throws \InvalidArgumentException if the $newState is invalid.
     */
    public function apply(string $transition): void
    {
        if (!$this->can($transition)) {
            throw new \InvalidArgumentException("Invalid transition '$transition'.");
        }

        $this->state = match ($transition) {
            self::TO_YELLOW => self::YELLOW,
            self::TO_GREEN => self::GREEN,
            self::TO_RED => self::RED,
            default => throw new \InvalidArgumentException("Invalid transition '$transition'.")
        };
    }
}
