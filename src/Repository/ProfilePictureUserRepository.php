<?php

namespace App\Repository;

use App\Entity\ProfilePictureUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method ProfilePictureUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilePictureUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilePictureUser[]    findAll()
 * @method ProfilePictureUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilePictureUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilePictureUser::class);
    }

    // /**
    //  * @return ProfilePictureUser[] Returns an array of ProfilePictureUser objects
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
    public function findOneBySomeField($value): ?ProfilePictureUser
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
