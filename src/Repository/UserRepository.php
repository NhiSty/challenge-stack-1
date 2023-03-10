<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{

    public function __construct(ManagerRegistry $registry, private readonly UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        if ($entity->getPlainPassword() !== null) {
            if ($this->passwordHasher->isPasswordValid($entity, $entity->getPlainPassword())) {
                return;
            } else {
                $entity->setPassword($this->passwordHasher->hashPassword($entity, $entity->getPlainPassword()));
            }
        } else {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $entity->getPassword()));
        }


        $this->getEntityManager()->persist($entity);


        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public
    function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public
    function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public
    function findUsersByLastName(string $query): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.lastname LIKE :query')
            ->andWhere('u.speciality IS NOT NULL')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public
    function findUsersByFistName(string $query): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.firstname LIKE :query')
            ->andWhere('u.speciality IS NOT NULL')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return UserFixture[] Returns an array of UserFixture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserFixture
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
