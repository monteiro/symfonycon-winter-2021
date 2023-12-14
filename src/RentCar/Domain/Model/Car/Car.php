<?php

namespace App\RentCar\Domain\Model\Car;

use App\DDDBundle\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Car
{
    use AggregateRoot;
    
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "string", length: 36)]
    private string $id;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $brand;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $model;
    
    #[ORM\Column(type: "string", length: 255)]
    private string $category;
    
    public static function create(string $id, string $brand, string $model, string $category, string $actorId): self {
        return new self($id, $brand, $model, $category, $actorId);
    }
    
    private function __construct(string $id, string $brand, string $model, string $category, string $actorId)
    {
        $this->id       = $id;
        $this->brand    = $brand;
        $this->model    = $model;
        $this->category = $category;
        
        $this->record(new CarWasCreated($id, $actorId));
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }
    
    public function getCategory(): ?string
    {
        return $this->category;
    }
}
