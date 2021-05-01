<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Service\UuidGenerator;
use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ApiResource(
 *     collectionOperations={"post"},
 *     itemOperations={"get"},
 * )
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @HasLifecycleCallbacks
 */
class Message
{
    /**
     * @ApiProperty(identifier=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $message = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $color = null;

    /**
     * @ApiProperty(identifier=true)
     * @ORM\Column(type="string", unique=true)
     */
    private string $uuid;

    /**
     * @ORM\Column(type="datetime")
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

    /**
     * @ORM\PrePersist
     */
    public function generateShortUuid(): void
    {
        $generator = new UuidGenerator();
        $this->setUuid($generator->getUuidShort());
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt)
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message = ""): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color = ""): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
