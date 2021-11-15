<?php


namespace App\RentCar\Application\Reservation;


final class CreateReservationCommand
{
    private string $location;
    private \DateTimeImmutable $pickUpAt;
    private \DateTimeImmutable $returnAt;
    private string $category;
    private string $customerId;
    private string $actorId;

    /**
     * @param string $location
     * @param \DateTimeImmutable $pickUpAt
     * @param \DateTimeImmutable $returnAt
     * @param string $category
     * @param string $customerId
     */
    public function __construct(string $location, \DateTimeImmutable $pickUpAt, \DateTimeImmutable $returnAt, string $category, string $customerId, string $actorId)
    {
        $this->location   = $location;
        $this->pickUpAt   = $pickUpAt;
        $this->returnAt   = $returnAt;
        $this->category   = $category;
        $this->customerId = $customerId;
        $this->actorId = $actorId;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPickUpAt(): \DateTimeImmutable
    {
        return $this->pickUpAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getReturnAt(): \DateTimeImmutable
    {
        return $this->returnAt;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @return string
     */
    public function getActorId(): string
    {
        return $this->actorId;
    }
    
    
    
}