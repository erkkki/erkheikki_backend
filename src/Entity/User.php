<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Service\UuidGenerator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{

    public function __construct()
    {
        $generator = new UuidGenerator();
        $this->setUuid($generator->getUuid());
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Ignore()
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $uuid;

    /**
     * @ORM\Column(type="boolean")
     * @Ignore()
     */
    private bool $enabled = false;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Ignore()
     */
    private string $googleId;

    /**
     * @ORM\Column(type="json")
     * @var array<string> $roles
     * @Ignore()
     */
    private array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getGoogleId(): string
    {
        return $this->googleId;
    }

    /**
     * @param string $googleId
     */
    public function setGoogleId(string $googleId): void
    {
        $this->googleId = $googleId;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->uuid;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * This method is not needed for apps that do not check user passwords.
     *
     * @see UserInterface
     * @Ignore()
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * This method is not needed for apps that do not check user passwords.
     *
     * @see UserInterface
     * @Ignore()
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEnabled(bool $true): void
    {
        $this->enabled = $true;
    }
}