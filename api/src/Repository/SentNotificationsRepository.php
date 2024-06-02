<?php

namespace App\Repository;

use App\Entity\SentNotifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SentNotifications>
 *
 * @method SentNotifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method SentNotifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method SentNotifications[]    findAll()
 * @method SentNotifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentNotificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SentNotifications::class);
    }

    //    /**
    //     * @return SentNotifications[] Returns an array of SentNotifications objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SentNotifications
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
