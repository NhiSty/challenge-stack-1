<?php

namespace App\Repository;

use App\Entity\Demand;
use App\Entity\DocumentStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentStorage>
 *
 * @method DocumentStorage|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentStorage|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentStorage[]    findAll()
 * @method DocumentStorage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentStorageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentStorage::class);
    }

    public function save(DocumentStorage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DocumentStorage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findDemandedDocumentsOfUser(int $user_id, $query): array
    {
        return $this->createQueryBuilder('docs')
            ->select('docs')
            ->join(Demand::class, 'dem', Join::WITH, 'dem.applicant = docs.user_id')
            ->where('docs.user_id = :user_id')
            ->andWhere('docs.name in (:query)')
            ->setParameter('user_id', $user_id)
            ->setParameter('query', $query)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return DocumentStorage[] Returns an array of DocumentStorage objects
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

//    public function findOneBySomeField($value): ?DocumentStorage
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
