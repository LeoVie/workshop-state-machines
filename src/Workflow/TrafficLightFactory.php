<?php

declare(strict_types=1);

namespace App\Workflow;

use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Transition;

class TrafficLightFactory
{
    public static function create()
    {
        $builder = new DefinitionBuilder(['green', 'yellow', 'red']);
        $builder
            ->addTransition(new Transition('to_green', 'yellow', 'green'))
            ->addTransition(new Transition('to_yellow', 'green', 'yellow'))
            ->addTransition(new Transition('to_yellow', 'red', 'yellow'))
            ->addTransition(new Transition('to_red', 'yellow', 'red'));

        $definition = $builder->build();

        return new StateMachine($definition, new MethodMarkingStore(singleState: true, property: 'state'));
    }
}
