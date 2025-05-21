<?php

namespace App\Repository;

use App\Entity\Ferias;
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

}
