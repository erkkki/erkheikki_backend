<?php

namespace App\Entity\piRadio;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FavouriteStationRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get"={"object.User == user"},
 *         "post"={"object.User == user"}
 *     },
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"read"}}
 * )
 * @ORM\Entity(repositoryClass=FavouriteStationRepository::class)
 * @HasLifecycleCallbacks
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
     */
    private ?User $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private ?string $stationuuid;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    private DateTime $createdAt;


    /**
     * @ORM\PrePersist
     */
    public function setCreatedTime(): void
    {
        $dateTimeNow = new DateTime('now');
        $this->setCreatedAt($dateTimeNow);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
