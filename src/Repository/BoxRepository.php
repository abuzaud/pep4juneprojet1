<?php

namespace App\Repository;

use App\Entity\Box;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Box|null find($id, $lockMode = null, $lockVersion = null)
 * @method Box|null findOneBy(array $criteria, array $orderBy = null)
 * @method Box[]    findAll()
 * @method Box[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoxRepository extends ServiceEntityRepository
{
    private $em;


    public function __construct(RegistryInterface $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Box::class);
        $this->em = $em;
    }

    public function findByPlaces(array $places)
    {
        $max = count($places);

        $query = $this->createQueryBuilder('b');

        foreach ($places as $i => $place){
            $query->orWhere("b.currentPlace = :place$i")
                ->setParameter("place$i", $place);
        }
        $query->orderBy('b.id', 'ASC');
        return $query->getQuery()->execute();

    }

//    /**
//     * @return Box[] Returns an array of Box objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
