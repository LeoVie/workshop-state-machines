<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class TrafficLightLogger implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }


    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.traffic_light.leave' => 'onLeave',
        ];
    }


    public function onLeave(Event $event): void
    {
        $this->logger->alert(sprintf(
                'Moved from "%s" to "%s".',
                implode(', ', $event->getTransition()->getFroms()),
                implode(', ', $event->getTransition()->getTos()))
        );
    }
}
