<?php

namespace UserBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use UserBundle\Entity\User;

class RegistrationCompletedEvent extends Event
{
    public function __construct(
        protected User $user,
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
