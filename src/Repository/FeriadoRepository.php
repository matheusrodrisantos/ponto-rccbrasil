<?php

namespace App\Repository;

use App\Entity\Feriado;
use App\Entity\ValueObject\DataFeriado;
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
     * @param DataFeriado $date The date to search for.
     * @return Feriado|null Returns a Feriado object if found, otherwise null.
     */
    public function findByDate(DataFeriado $date): ?Feriado
    {
        return $this->findOneBy([
            'data.dia' => $date->getDia(),
            'data.mes' => $date->getMes()
        ]);
    }

    public function findByDateActive(DataFeriado $date): ?Feriado
    {
        return $this->findOneBy([
            'data.dia' => $date->getDia(),
            'data.mes' => $date->getMes(),
            'status' => true
        ]);
    }
    public function create(Feriado $feriado): ?Feriado
    {
        if ($this->findFeriado($feriado)) {
            return $feriado;
        }

        $em = $this->getEntityManager();

        try {
            $em->persist($feriado);
            $em->flush();

            return $feriado;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao criar feriado: ' . $e->getMessage());
        }
    }

    public function findFeriado(Feriado $feriado): ?Feriado
    {
        return $this->findOneBy([
            'data.dia' => $feriado->getData()->getDia(),
            'data.mes' => $feriado->getData()->getMes()
        ]);
    }


    public function update(Feriado $feriado): ?Feriado
    {
        try {
            $em = $this->getEntityManager();
            $em->persist($feriado);
            $em->flush();

            return $feriado;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao atualizar feriado: ' . $e->getMessage());
        }
    }
}
