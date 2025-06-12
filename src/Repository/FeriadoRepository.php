<?php

namespace App\Repository;

use App\Entity\Feriado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeImmutable;

/**
 * @extends ServiceEntityRepository<Feriado>
 */
class FeriadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feriado::class);
    }

    /**
     * Finds a holiday by its start date.
     *
     * @param DateTimeImmutable $date The date to search for.
     * @return Feriado|null Returns a Feriado object if found, otherwise null.
     */
    public function findByDate(DateTimeImmutable $date): ?Feriado
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.inicio = :date') // Assuming 'inicio' is the field that stores the holiday date
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Feriado[] Returns an array of Feriado objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Feriado
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
