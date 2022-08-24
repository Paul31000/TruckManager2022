<?php

namespace App\Repository;

use App\Entity\PositionHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PositionHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PositionHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PositionHistory[]    findAll()
 * @method PositionHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PositionHistory::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PositionHistory $entity, bool $flush = true): void
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
    public function remove(PositionHistory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     * @return PositionHistory[] Returns an array of PositionHistory objects
     */
    public function findPositionHistory(int $id)
    {
        return $this->createQueryBuilder('sh')
        ->andWhere('sh.camion = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult()
        ;
    }


    
    // /**
    //  * @return PositionHistory[] Returns an array of PositionHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PositionHistory
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
