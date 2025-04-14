<?php

namespace UserBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use UserBundle\Entity\User;

class RegistrationConfirmedEvent extends Event
{
    protected function __construct(
        protected User $user
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
