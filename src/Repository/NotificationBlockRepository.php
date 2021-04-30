<?php

namespace App\Repository;

use App\Entity\NotificationBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotificationBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationBlock[]    findAll()
 * @method NotificationBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationBlock::class);
    }

    // /**
    //  * @return NotificationBlock[] Returns an array of NotificationBlock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotificationBlock
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
