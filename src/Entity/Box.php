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
     * @ORM\Column(type="integer", nullable=false)
     */
    private $budget;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $currentPlace;
    

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Box
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param $products
     * @return Box
     */
    public function setProducts($products): self
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $budget
     */
    public function setBudget($budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @return null|string
     */
    public function getCurrentPlace(): ?string
    {
        return $this->currentPlace;
    }

    /**
     * @param null|string $currentPlace
     * @return Box
     */
    public function setCurrentPlace(?string $currentPlace): self
    {
        $this->currentPlace = $currentPlace;

        return $this;
    }

    

}
