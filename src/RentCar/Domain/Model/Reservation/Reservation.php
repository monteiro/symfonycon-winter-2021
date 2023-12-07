<?php

namespace App\RentCar\Domain\Model\Reservation;

use App\RentCar\Domain\Common\AggregateRoot;
use App\RentCar\Domain\Model\Customer\Customer;
use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Reservation
{
    use AggregateRoot;
    
    private const VALID_CATEGORIES = ['standard', 'intermediate', 'premium'];
    private const STATUS_CANCELLED = 'cancelled';
    private const VALID_STATUS = ['pending', self::STATUS_CANCELLED, 'completed'];
    
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "string", length: 36)]
    private string $id;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $location;
    
    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $pickUpAt;
    
    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $returnAt;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $category;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $status;

    private string $actorId;
    
    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: "id")]
    private Customer $customer;

    public static function create(
        string $id,
        string $location,
        \DateTimeImmutable $pickUpAt,
        \DateTimeImmutable $returnAt,
        string $category,
        string $actorId,
        Customer $customer
    ) {
        return new self(
            $id, 
            $location, 
            $pickUpAt, 
            $returnAt, 
            $category,
            $actorId,
            $customer,
            
        );
    }
    
    private function __construct(
        string $id, 
        string $location, 
        \DateTimeImmutable $pickUpAt, 
        \DateTimeImmutable $returnAt, 
        string $category, 
        string $actorId,
        Customer $customer
    ) {
        Assertion::notBlank($location);
        Assertion::greaterThan($returnAt, $pickUpAt);
        Assertion::inArray($category, self::VALID_CATEGORIES);
        Assertion::uuid($actorId);
        
        $this->id       = $id;
        $this->location = $location;
        $this->pickUpAt = $pickUpAt;
        $this->returnAt = $returnAt;
        $this->category = $category;
        $this->customer = $customer;
        $this->actorId = $actorId;
        $this->status = 'pending';

        $this->record(new ReservationWasCreated($id, $actorId));
    }
    
    public function cancel(string $actorId) {
        Assertion::uuid($actorId);
        if ($this->status === self::STATUS_CANCELLED) {
            throw new \InvalidArgumentException(sprintf('The reservation with id "%s" was already cancelled', $this->id));
        }
        
        $this->status = self::STATUS_CANCELLED;
        
        $this->record(new ReservationWasCancelled($this->id, $actorId));
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getPickUpAt(): \DateTimeImmutable
    {
        return $this->pickUpAt;
    }

    public function getReturnAt(): \DateTimeImmutable
    {
        return $this->returnAt;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getActorId(): string
    {
        return $this->actorId;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
