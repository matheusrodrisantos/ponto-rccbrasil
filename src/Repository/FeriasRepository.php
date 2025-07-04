<?php

namespace App\Repository;

use App\Entity\Ferias;
use App\Entity\Funcionario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ferias>
 */
class FeriasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ferias::class);
    }

    public function create(Ferias $ferias): Ferias
    {
        $em = $this->getEntityManager();
        $em->persist($ferias);
        $em->flush();

        return $ferias;
    }

    public function buscarPorPeriodo(
        \DateTime $inicio,
        \DateTime $fim,
        int $idFuncionario
    ): array {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.funcionario', 'func')
            ->andWhere('f.dataFerias.dataIni <= :fim')
            ->andWhere('func.id = :idFuncionario')
            ->andWhere('f.dataFerias.dataFim >= :inicio')
            ->setParameter('inicio', $inicio)
            ->setParameter('fim', $fim)
            ->setParameter('idFuncionario', $idFuncionario)
            ->getQuery()
            ->getResult();
    }
}
