<?php

namespace App\Repository;

use App\Entity\Candidat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Candidat $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Candidat $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Candidat[] Returns an array of Candidat objects
    */
    
    public function findActif(bool $value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.actif = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Candidat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
