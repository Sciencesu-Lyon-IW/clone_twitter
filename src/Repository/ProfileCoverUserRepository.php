<?php

namespace App\Repository;

use App\Entity\ProfileCoverUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method ProfileCoverUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileCoverUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileCoverUser[]    findAll()
 * @method ProfileCoverUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileCoverUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileCoverUser::class);
    }

    // /**
    //  * @return ProfileCoverUser[] Returns an array of ProfileCoverUser objects
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
    public function findOneBySomeField($value): ?ProfileCoverUser
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
