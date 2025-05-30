<?php

namespace App\Repository;

use App\Entity\Funcionario;
use App\Entity\RegistroPonto;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegistroPonto>
 */
class RegistroPontoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistroPonto::class);
    }

    public function create(RegistroPonto $registroPonto): RegistroPonto
    {
        $em = $this->getEntityManager();
        $em->persist(object: $registroPonto);
        $em->flush();

        return $registroPonto;
    }

    public function procurarPorPontoAberto(DateTimeImmutable $data, Funcionario $funcionario):? RegistroPonto{
        
        return $this->findOneBy([
            'data' => $data,
            'funcionario' => $funcionario,
            'batidaPonto.saida'=>null
        ]);
    }

    //    /**
    //     * @return RegistroPonto[] Returns an array of RegistroPonto objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RegistroPonto
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
