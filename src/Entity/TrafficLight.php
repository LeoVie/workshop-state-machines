<?php

declare(strict_types=1);

namespace App\Entity;

use App\StateAwareInterface;

class TrafficLight implements StateAwareInterface
{
    /** @var string State. (Exercise 1) This variable name is used in tests. Do not rename.  */
    private $state;

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }
}