<?php

declare(strict_types=1);

namespace App;

use App\Service\Database;
use App\Service\MailerService;
use App\StateMachine\State\AddYourEMail;
use App\StateMachine\State\Welcome;
use App\StateMachine\StateMachine;

class Worker
{
    private $db;
    private $mailer;

    public function __construct(Database $em, MailerService $mailer)
    {
        $this->db = $em;
        $this->mailer = $mailer;
    }

    public function run()
    {
        $users = $this->db->getAllUsers();

        foreach ($users as $user) {
            (new StateMachine($this->mailer, $user))->start(new AddYourEMail());
        }

        $this->db->saveUsers($users);
    }
}
