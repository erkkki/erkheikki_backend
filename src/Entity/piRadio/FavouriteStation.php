<?php

namespace App\Entity\piRadio;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FavouriteStationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FavouriteStationRepository::class)
 */
class FavouriteStation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $User;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $stationuuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getStationuuid(): ?string
    {
        return $this->stationuuid;
    }

    public function setStationuuid(string $stationuuid): self
    {
        $this->stationuuid = $stationuuid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
