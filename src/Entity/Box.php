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
     * @ORM\Column(type="float", nullable=false)
     */
    private $budget;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $products;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $validate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_sent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $currentPlace;


    /**
     * Box constructor.
     */
    public function __construct()
    {
        $this->currentPlace = 'edition';
        $this->validate = false;
        $this->is_sent = false;
    }

    /**
     * @return mixed
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getIsValidate()
    {
        return $this->validate;
    }

    /**
     * @param mixed $validate
     */
    public function setIsValidate($validate): void
    {
        $this->validate = $validate;
    }

    /**
     * @return mixed
     */
    public function getIsSent()
    {
        return $this->is_sent;
    }

    /**
     * @param mixed $is_sent
     */
    public function setIsSent($is_sent): void
    {
        $this->is_sent = $is_sent;
    }

    public function isCompleted(){
        if(
            !empty($this->getName()) &&
            !empty($this->getBudget()) &&
            !empty($this->getReference()) &&
            !empty($this->getDescription()) &&
            !empty($this->getProducts())
        ){
            return true;
        } else {
            return false;
        }
    }
}
