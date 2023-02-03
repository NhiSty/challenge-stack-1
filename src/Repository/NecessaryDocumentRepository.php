<?php

namespace App\Repository;

use App\Entity\NecessaryDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NecessaryDocument>
 *
 * @method NecessaryDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method NecessaryDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method NecessaryDocument[]    findAll()
 * @method NecessaryDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NecessaryDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NecessaryDocument::class);
    }

    public function save(NecessaryDocument $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NecessaryDocument $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NecessaryDocument[] Returns an array of NecessaryDocument objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NecessaryDocument
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
