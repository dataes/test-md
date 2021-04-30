<?php

namespace App\Repository;

use App\Entity\NotificationBlockContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotificationBlockContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationBlockContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationBlockContent[]    findAll()
 * @method NotificationBlockContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationBlockContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationBlockContent::class);
    }

    // /**
    //  * @return NotificationBlockContent[] Returns an array of NotificationBlockContent objects
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
    public function findOneBySomeField($value): ?NotificationBlockContent
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
