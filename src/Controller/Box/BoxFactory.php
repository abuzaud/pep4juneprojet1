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
        $box->setCurrentPlace($request->getCurrentPlace());

        return $box;
    }

    /**
     * Fonction permettant de modifier une box
     * @param Box $box
     * @param BoxRequest $request
     * @return Box
     */
    public function modifyFromBoxRequest(Box $box, BoxRequest $request): Box
    {
        $box->setId($request->getId());
        $box->setName($request->getName());
        $box->setBudget($request->getBudget());
        $box->setProducts($request->getProducts());
        $box->setDescription($request->getDescription());
        $box->setReference($request->getReference());
        $box->setCurrentPlace($request->getCurrentPlace());

        return $box;
    }
}