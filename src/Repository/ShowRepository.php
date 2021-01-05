<?php

namespace App\Repository;

use App\Entity\Show;
use App\Entity\ShowSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Show|null find($id, $lockMode = null, $lockVersion = null)
 * @method Show|null findOneBy(array $criteria, array $orderBy = null)
 * @method Show[]    findAll()
 * @method Show[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Show::class);
    }

    /**
    * @return Show[] Returns an array of Show objects
    */
    public function findByRecentDate()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Show[] Returns an array of Show objects
     */
    public function findByShowSearch(ShowSearch $search){
        $query=$this->createQueryBuilder('s');
        if($search->getBand()){
            $query->andWhere('s.band = :band');
            $query->setParameter("band", $search->getBand());
        }
        if($search->getDate()){
            $query->andWhere('s.date = :date');
            $query->setParameter("date", $search->getDate());
        }
        return $query->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Show
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
