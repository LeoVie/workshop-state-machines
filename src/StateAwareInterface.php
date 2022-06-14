<?php

declare(strict_types=1);

namespace App;

interface StateAwareInterface
{
    public function setState(string $state): void;

    public function getState(): string;
}