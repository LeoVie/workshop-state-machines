<?php

declare(strict_types=1);

namespace App\StateMachine\State;

use App\Entity\User;
use App\Service\MailerService;
use App\StateMachine\StateMachineInterface;
use App\WorldClock;

class AddYourEMail implements StateInterface
{
    private const DAYS_TO_WAIT_BETWEEN_NOTIFICATIONS = 1;

    public function send(StateMachineInterface $stateMachine, MailerService $mailer): int
    {
        $user = $stateMachine->getUser();

        if ($user->getEmail() === null) {
            if ($this->shouldGetNotified($user)) {
                $mailer->sendEmail($user, 'Please add your email.');
                $user->setLastTimeNotifiedAboutEmail(WorldClock::getDateTimeRelativeFakeTime());
            }

            return StateInterface::STOP;
        }

        $stateMachine->setState(new AddYourName());

        return StateInterface::CONTINUE;
    }

    private function shouldGetNotified(User $user): bool
    {
        if ($user->getLastTimeNotifiedAboutEmail() === null) {
            return true;
        }

        return WorldClock::getDateTimeRelativeFakeTime()->diff($user->getLastTimeNotifiedAboutEmail())->days >= self::DAYS_TO_WAIT_BETWEEN_NOTIFICATIONS;
    }
}