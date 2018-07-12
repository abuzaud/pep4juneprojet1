<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller\Box;


use App\Entity\Box;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Workflow\Registry;


class BoxRequest
{
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner un nom")
     * @var
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner un budget")
     * @Assert\Range(
     *     min="1",
     *     minMessage="Votre budget est trop faible."
     * )
     * @var
     */
    private $budget;

    private $products;

    /**
     * @Assert\Type("string")
     * @var
     */
    private $description;

    /**
     * @Assert\Type("string")
     * @var
     */
    private $reference;

    private $currentPlace;

    private $validate;

    private $is_sent;

    /**
     * BoxRequest constructor.
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
    public function getisSent()
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

    public function createBoxRequestFromBox(Box $box): self
    {
        $boxRequest = new self();
        $boxRequest->setId($box->getId());
        $boxRequest->setName($box->getName());
        $boxRequest->setBudget($box->getBudget());
        $boxRequest->setDescription($box->getDescription());
        $boxRequest->setReference($box->getReference());
        $boxRequest->setProducts($box->getProducts());
        $boxRequest->setCurrentPlace($box->getCurrentPlace());
        return $boxRequest;
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