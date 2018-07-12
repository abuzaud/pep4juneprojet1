<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller\Box;


use App\Entity\Box;

class BoxFactory
{
    /**
     * Fonction permettant de créer une box
     * @param BoxRequest $request
     * @return Box
     */
    public function createFromBoxRequest(BoxRequest $request): Box
    {
        $box = new Box();
        $box->setId($request->getId());
        $box->setName($request->getName());
        $box->setBudget($request->getBudget());
        $box->setProducts($request->getProducts());
        $box->setDescription($request->getDescription());
        $box->setReference($request->getReference());
        $box->setIsValidate($request->getIsValidate());
        $box->setIsSent($request->getisSent());
        $box->setCurrentPlace($request->getCurrentPlace());

        return $box;
    }

    /**
     * Fonction permettant de modifier une box
     * @param Box $box
     * @param BoxRequest $request
     * @return Box
     */
    public function modifyFromBoxRequest(BoxRequest $request, Box $box): Box
    {
        $box->setId($request->getId());
        $box->setName($request->getName());
        $box->setBudget($request->getBudget());
        $box->setProducts($request->getProducts());
        $box->setDescription($request->getDescription());
        $box->setReference($request->getReference());
        $box->setIsValidate($request->getIsValidate());
        $box->setIsSent($request->getisSent());
        $box->setCurrentPlace($request->getCurrentPlace());

        return $box;
    }
}