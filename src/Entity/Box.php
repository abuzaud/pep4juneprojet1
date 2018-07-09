<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxRepository")
 */
class Box
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currentPlace;

    public function getId()
    {
        return $this->id;
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

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getCurrentPlace(): ?string
    {
        return $this->currentPlace;
    }

    public function setCurrentPlace(?string $currentPlace): self
    {
        $this->currentPlace = $currentPlace;

        return $this;
    }
}
