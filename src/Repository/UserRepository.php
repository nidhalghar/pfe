<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

//    /**
//     * @return User[] Returns an array of User objects
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

    public function search($query)
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.domaine LIKE :query')
            ->orWhere('u.nom LIKE :query')
            ->orWhere('u.prenom LIKE :query')
            ->orWhere('u.email LIKE :query')
            ->orWhere('u.numtel LIKE :query')
            ->setParameter('query', '%' . $query . '%');

        return $qb->getQuery()->getResult();
    }

    public function advanced_search($domaine,$experience,$certificat,$competences,$niveau)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM User u
            left join  Competences c on c.user_id = u.id
            left join  Certificat f on f.user_id=u.id
            WHERE u.domaine LIKE :domaine
            and u.annee_experience = :experience
            and f.nom_certificat LIKE :certificat
            and c.technologies LIKE :competences
            and c.niveau LIKE :niveau 
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(
        [
            'domaine' => $domaine,
            'experience' => $experience,
            'certificat' => $certificat,
            'competences' => $competences,
            'niveau' => $niveau
        ]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
        /*
        $qb = $this->createQueryBuilder('u')  
        ->addSelect('c') // to make Doctrine actually use the join
        ->leftJoin('u.competences', 'c')
        ->where('u.domaine LIKE :domaine')
        ->andWhere('u.anneeExperience = :experience')
        //->andWhere('u.certificat LIKE :certificat')
        ->andWhere('c.technologies LIKE :competences' )
        ->andWhere('c.niveau LIKE :niveau')
        
        
        ->setParameter('domaine', '%' . $domaine . '%')
        ->setParameter('experience',  $experience )
        //->setParameter('certificat', '%' . $certificat . '%')
        ->setParameter('technologies', '%' . $competences . '%')
        ->setParameter('niveau', '%' . $niveau . '%');
        return $qb->getQuery()->getResult();
        */
    }
    


}
