<?php

namespace App\Repository;

use App\Entity\Funcionario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use App\Entity\Departamento;

/**
 * @extends ServiceEntityRepository<Funcionario>
 */
class FuncionarioRepository extends ServiceEntityRepository 
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Funcionario::class);
    }


    public function create(Funcionario $funcionario): Funcionario
    {
        $em = $this->getEntityManager();
        $em->persist($funcionario);
        $em->flush();

        return $funcionario;
    }

    public function listarFuncionariosAtivos():?Funcionario{

        return $this->createQueryBuilder('f')
            ->andWhere('f.ativo = :ativo')
            ->setParameter('ativo', true)
            ->getQuery()
            ->getResult();
    }

    public function buscarFuncionarioAtivoPorId(int $id):?Funcionario{
        
        return $this->createQueryBuilder('f')
            ->andWhere('f.ativo = :ativo')
            ->andWhere('f.id=:id')
            ->setParameter('id', $id)
            ->setParameter('ativo', true)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function buscarSupervisorAtivo(int $id): ?Funcionario
    {
        $query = $this->createQueryBuilder('f')
            ->select('f', 'd')
            ->join('f.departamentoSupervisionado', 'd') // <-- ajuste o nome do relacionamento aqui
            ->andWhere('f.funcao = :funcao')
            ->andWhere('f.id = :id')
            ->andWhere('f.departamento = d')
            ->andWhere('f.ativo = :ativo')
            ->setParameter('funcao', 'SUPERVISOR')
            ->setParameter('id', $id)
            ->setParameter('ativo', true)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
    public function buscarGerenteOuRhAtivo(int $id):?Funcionario{
        
        $query=$this->createQueryBuilder('f')
            ->andWhere('f.funcao IN (:funcoes)')
            ->andWhere('f.id = :id')
            ->andWhere('f.ativo=:ativo')
            ->setParameter('funcoes', ['GERENTE', 'RH'])
            ->setParameter('id', $id)
            ->setParameter('ativo',true)
            ->getQuery()
            ->getOneOrNullResult();

            


        return $query;
    } 

}
