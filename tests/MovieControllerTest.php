<?php

declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public function testListAdminActionForAdmin(): void
    {
        $client = static::createClient();

        //SERVICES
        $em = static::getContainer()->get('doctrine')->getManager();
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $router = static::getContainer()->get('router');
        //

        $testUser = (new UserBundle\Entity\User())
             ->setEmail('admin@example.com')
             ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $hashedPassword = $passwordHasher->hashPassword(
            $testUser,
            'plain_test_password'
        );

        $testUser->setPassword($hashedPassword);

        $em->persist($testUser);
        $em->flush();

        $client->loginUser($testUser);

        $client->request('GET', $router->generate('admin_movie_movie_list'));

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextSame('h4', 'Movies');

        $em->remove($testUser);
        $em->flush();
    }

    public function testListAdminActionForUnauthorizedUser(): void
    {
        $client = static::createClient();

        $router = static::getContainer()->get('router');

        $client->request('GET', $router->generate('admin_movie_movie_list'));

        $this->assertResponseStatusCodeSame(302);
    }
}
