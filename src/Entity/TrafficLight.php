<?php

declare(strict_types=1);

namespace App\Entity;

use App\StateAwareInterface;

class TrafficLight implements StateAwareInterface
{
    public const GREEN = 'green';
    public const YELLOW = 'yellow';
    public const RED = 'red';

    private string $state;

    public function __construct(string $state = self::RED)
    {
        $this->state = $state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }
}