<?php

namespace App\RentCar\Application\Car;

class CreateCarCommand
{
    private string $brand;
    private string $model;
    private string $category;
    private string $actorId;

    public function __construct(string $brand, string $model, string $category, string $actorId)
    {
        $this->brand    = $brand;
        $this->model    = $model;
        $this->category = $category;
        $this->actorId = $actorId;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
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
    public function getActorId(): string
    {
        return $this->actorId;
    }
}