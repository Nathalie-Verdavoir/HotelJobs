<?php

namespace App\Repository;

use App\Entity\Postulant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Postulant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postulant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postulant[]    findAll()
 * @method Postulant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostulantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postulant::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Postulant $entity, bool $flush = true): void
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
    public function remove(Postulant $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
      * @return Postulant[] Returns an array of Postulant objects
      */
  
    public function findByCandidat($value)
    {
        return $this->createQueryBuilder('p')
            ->select('p.getCandidat = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Postulant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
