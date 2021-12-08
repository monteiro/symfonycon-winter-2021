<?php

namespace App\RentCar\Domain\Common;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StoredEventRepository;

/**
 * @ORM\Entity
 */
class StoredEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=32)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $typeName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $eventBody;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $aggregateRootId;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private ?string $actorId;

    /**
     * @ORM\Column(type="boolean")
     */
    private string $published;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $occurredOn;

    /**
     * @param $id
     * @param $typeName
     * @param $eventBody
     * @param $aggregateRootId
     * @param string|null $actorId
     */
    public function __construct($id, $typeName, $eventBody, $aggregateRootId, ?string $actorId)
    {
        $this->id              = $id;
        $this->typeName        = $typeName;
        $this->eventBody       = $eventBody;
        $this->aggregateRootId = $aggregateRootId;
        $this->actorId         = $actorId;
        
        $this->occurredOn = new \DateTimeImmutable();
        
        $this->published = false;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;

        return $this;
    }

    public function getEventBody(): string
    {
        return $this->eventBody;
    }

    public function setEventBody(string $eventBody): self
    {
        $this->eventBody = $eventBody;

        return $this;
    }

    public function getAggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function setAggregateRootId(string $aggregateRootId): self
    {
        $this->aggregateRootId = $aggregateRootId;

        return $this;
    }

    public function getActorId(): ?string
    {
        return $this->actorId;
    }
    
    public function markAsPublished(): void {
        $this->published = true;
    }
}
