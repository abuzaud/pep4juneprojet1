<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller\Box;


use App\Entity\Box;
use Doctrine\Common\Collections\ArrayCollection;

class BoxRequest
{
    private $id;

    private $name;

    private $budget;

    private $products;

    private $currentPlace;

    /**
     * BoxRequest constructor.
     * @param $products
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCurrentPlace()
    {
        return $this->currentPlace;
    }

    /**
     * @param mixed $currentPlace
     */
    public function setCurrentPlace($currentPlace): void
    {
        $this->currentPlace = $currentPlace;
    }

    public function createFromBoxRequest(Box $box): self
    {
        $boxRequest = new self();
        $boxRequest->setId($box->getId());
        $boxRequest->setName($box->getName());
        $boxRequest->setBudget($box->getBudget());
        $boxRequest->setProducts($box->getProducts());
        $boxRequest->setCurrentPlace($box->getCurrentPlace());
        return $boxRequest;
    }
}