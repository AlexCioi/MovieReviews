<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Trait\TimestampableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user__user')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected int $id;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    protected ?string $email;

    #[ORM\Column(type: Types::STRING, length: 180, nullable: true)]
    protected ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, length: 180, nullable: true)]
    protected ?string $lastName = null;

    #[ORM\Column(type: Types::JSON)]
    protected array $roles = [];

    #[ORM\Column(type: Types::STRING)]
    protected string $password;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $isVerified = false;

    #[ORM\Column(type: Types::STRING, length: 8, nullable: true)]
    protected ?string $locale = null;

    public function __construct()
    {
        $this->roles = array(
            'ROLE_USER'
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {

        $this->email = $email;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): User
    {
        $this->locale = $locale;

        return $this;
    }
}
