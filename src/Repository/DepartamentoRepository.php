<?php

namespace App\Repository;

use App\Entity\Departamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departamento>
 */
class DepartamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departamento::class);
    }

    public function create(Departamento $departamento): Departamento
    {
        $em = $this->getEntityManager();
        $em->persist($departamento);
        $em->flush();

        return $departamento;
    }

    public function update(Departamento $departamento): Departamento
    {
        $em = $this->getEntityManager();
        $em->persist($departamento);
        $em->flush();

        return $departamento;
    }

//    /**
//     * @return Departamento[] Returns an array of Departamento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departamento
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
