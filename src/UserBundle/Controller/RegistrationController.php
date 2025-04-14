<?php

namespace UserBundle\Controller;

use AppBundle\Utils\JsonRequestPayload;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use UserBundle\Entity\User;
use UserBundle\Event\RegistrationCompletedEvent;
use UserBundle\Events;
use UserBundle\Form\Type\Register\RegistrationFormType;
use UserBundle\Security\EmailVerifier;
use UserBundle\Service\RegistrationManager;

class RegistrationController extends AbstractController
{
    public function __construct(
        protected EmailVerifier $emailVerifier,
        protected EventDispatcherInterface $dispatcher,
        protected RegistrationManager $registrationService
    )
    {
    }

    /**
     * @throws Exception
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registrationService->validatePassword($form);

            if ($form->getErrors(true)->count() > 0) {
                return $this->render('@User/Registration/register.html.twig', [
                    'form' => $form,
                ]);
            }

            $plainPassword = $form->get('plainPassword')->getData();

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $event = new RegistrationCompletedEvent($user);
            $this->dispatcher->dispatch($event, Events::REGISTRATION_REGISTER_COMPLETED);

            return $this->redirectToRoute('user_security_login');
        }

        return $this->render('@User/Registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('user_registration_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('user_registration_register');
    }
}
