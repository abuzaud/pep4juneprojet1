<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller\Box;


use App\Entity\Box;

class BoxFactory
{
    public function createFromBoxRequest(BoxRequest $request): Box
    {
        $box = new Box();
        $box->setName($request->getName());
        $box->setBudget($request->getBudget());
        $box->setProducts($request->getProducts());
        $box->setCurrentPlace($request->getCurrentPlace());

        return $box;
    }
}