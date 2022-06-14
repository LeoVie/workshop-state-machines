<?php

declare(strict_types=1);

namespace App\StateMachine\State;

use App\Service\MailerService;
use App\StateMachine\StateMachineInterface;

class AddYourTwitter implements StateInterface
{
    public function send(StateMachineInterface $stateMachine, MailerService $mailer): int
    {
        $user = $stateMachine->getUser();

        if ($user->getTwitter() === null) {
            $mailer->sendEmail($user, 'Please add your twitter.');

            return StateInterface::STOP;
        }

        $stateMachine->setState(new FinalState());

        return StateInterface::CONTINUE;
    }

}