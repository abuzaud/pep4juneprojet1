<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller\Box;


use Doctrine\ORM\EntityManagerInterface;

class BoxRequestHandler
{
    private $em;

    private $boxFactory;

    public function __construct(EntityManagerInterface $entityManager, BoxFactory $boxFactory)
    {
        $this->em = $entityManager;
        $this->boxFactory = $boxFactory;
    }

    /**
     * @param BoxRequest $boxRequest
     * @return \App\Entity\Box
     */
    public function handle(BoxRequest $boxRequest)
    {
        // On utilise la factory pour créer la box
        $box = $this->boxFactory->createFromBoxRequest($boxRequest);

        // On ajoute la box à la base de données
        $this->em->persist($box);
        $this->em->flush();

        return $box;
    }
}