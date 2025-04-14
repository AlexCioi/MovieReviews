<?php

namespace UserBundle\Service;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

class RegistrationManager
{
    public function validatePassword(FormInterface $form): void
    {
        $plainPassword = $form->get('plainPassword')->getData();
        $confirmationPassword = $form->get('confirmPassword')->getData();

        if ($plainPassword !== $confirmationPassword) {
            $form->get('confirmationPassword')->addError(new FormError('Confirmation password not the same as the entered password'));
        }
    }
}
