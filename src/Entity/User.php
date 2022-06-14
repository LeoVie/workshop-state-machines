<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    private $id;
    private $name;
    private $email;
    private $twitter;
    private ?\DateTimeImmutable $lastTimeNotifiedAboutEmail;
    private ?\DateTimeImmutable $lastTimeNotifiedAboutName;

    /**
     * Convert a user to array (used when we store user in database)
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'twitter' => $this->twitter,
            'lastTimeNotifiedAboutEmail' => $this->lastTimeNotifiedAboutEmail?->format('Y-m-d H:i:s'),
            'lastTimeNotifiedAboutName' => $this->lastTimeNotifiedAboutName?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Convert a array to a user
     */
    public static function fromArray(array $data): User
    {
        $user = new self();

        $user->id = (int) $data['id'];
        $user->name = $data['name'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->twitter = $data['twitter'] ?? null;
        $user->lastTimeNotifiedAboutEmail = $data['lastTimeNotifiedAboutEmail'] ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['lastTimeNotifiedAboutEmail']) : null;
        $user->lastTimeNotifiedAboutName = $data['lastTimeNotifiedAboutName'] ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['lastTimeNotifiedAboutName']) : null;

        return $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email)
    {
        $this->email = $email;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter)
    {
        $this->twitter = $twitter;
    }

    public function getLastTimeNotifiedAboutEmail(): ?\DateTimeImmutable
    {
        return $this->lastTimeNotifiedAboutEmail;
    }

    public function setLastTimeNotifiedAboutEmail(?\DateTimeImmutable $lastTimeNotifiedAboutEmail): void
    {
        $this->lastTimeNotifiedAboutEmail = $lastTimeNotifiedAboutEmail;
    }

    public function getLastTimeNotifiedAboutName(): ?\DateTimeImmutable
    {
        return $this->lastTimeNotifiedAboutName;
    }

    public function setLastTimeNotifiedAboutName(?\DateTimeImmutable $lastTimeNotifiedAboutName): void
    {
        $this->lastTimeNotifiedAboutName = $lastTimeNotifiedAboutName;
    }
}
