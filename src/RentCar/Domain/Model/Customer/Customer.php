<?php

namespace App\RentCar\Domain\Model\Customer;

use App\DDDBundle\Domain\AggregateRoot;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Customer
{
    use AggregateRoot;
    
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "string", length: 36)]
    private string $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $address;
    
    #[ORM\Column(type: "string", length: 50)]
    private string $phone;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $email;
    private string $actorId;

    /**
     * @throws AssertionFailedException
     */
    public static function create(string $id, string $name, string $address, string $phone, string $email, string $actorId) {
        return new self($id, $name, $address, $phone, $email, $actorId);
    }
    
    /**
     * @throws AssertionFailedException
     */
    private function __construct(string $id, string $name, string $address, string $phone, string $email, string $actorId)
    {
        Assertion::uuid($id);
        Assertion::maxLength($address, 255);
        Assertion::maxLength($phone, 50);
        Assertion::email($email);
        Assertion::maxLength($address, 255);
        
        $this->id      = $id;
        $this->name    = $name;
        $this->address = $address;
        $this->phone   = $phone;
        $this->email   = $email;
        $this->actorId = $actorId;

        $this->record(new CustomerWasCreated($id, $actorId));
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getActorId(): string
    {
        return $this->actorId;
    }
}
