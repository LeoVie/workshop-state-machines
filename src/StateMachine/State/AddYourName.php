<?php

declare(strict_types=1);

namespace App\StateMachine\State;

use App\Entity\User;
use App\Service\MailerService;
use App\StateMachine\StateMachineInterface;
use App\WorldClock;

class AddYourName implements StateInterface
{
    private const DAYS_TO_WAIT_BETWEEN_NOTIFICATIONS = 3;

    public function send(StateMachineInterface $stateMachine, MailerService $mailer): int
    {
        $user = $stateMachine->getUser();

        if ($user->getName() === null) {
            if ($this->shouldGetNotified($user)) {
                $mailer->sendEmail($user, 'Please add your name.');
                $user->setLastTimeNotifiedAboutName(WorldClock::getDateTimeRelativeFakeTime());
            }

            return StateInterface::STOP;
        }

        $stateMachine->setState(new AddYourTwitter());

        return StateInterface::CONTINUE;
    }

    private function shouldGetNotified(User $user): bool
    {
        if ($user->getLastTimeNotifiedAboutName() === null) {
            return true;
        }

        return WorldClock::getDateTimeRelativeFakeTime()->diff($user->getLastTimeNotifiedAboutName())->days >= self::DAYS_TO_WAIT_BETWEEN_NOTIFICATIONS;
    }
}