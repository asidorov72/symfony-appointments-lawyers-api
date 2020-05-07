<?php

namespace App\Repository;

use App\Entity\Citizen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Citizen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citizen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citizen[]    findAll()
 * @method Citizen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitizenRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Citizen::class);

        $this->manager = $manager;
    }

    public function save(array $data) : bool
    {
        $citizenEntity = new Citizen();

        $citizenEntity->setPassword($data['password']);

        $citizenEntity->setEmail($data['email']);

        $citizenEntity->setFirstName($data['firstName']);

        $citizenEntity->setLastName($data['lastName']);

        $citizenEntity->setPhoneNumber($data['phoneNumber']);

        $citizenEntity->setTitle($data['title']);

        $citizenEntity->setDateOfBirth($data['dateOfBirth']);

        empty($data['postalCode']) ? true : $citizenEntity->setPostalCode($data['postalCode']);

        empty($data['postalAddress']) ? true : $citizenEntity->setPostalAddress($data['postalAddress']);

        empty($data['country']) ? true : $citizenEntity->setCountry($data['country']);

        try{
            $this->manager->persist($citizenEntity);
            $this->manager->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findAllByOffset(array $criteria) : array
    {
        return $this->createQueryBuilder('c')
            ->setMaxResults($criteria['limit'])
            ->setFirstResult($criteria['offset'])
            ->orderBy('c.' . $criteria['orderBy']['field'], $criteria['orderBy']['order'])
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Citizen[] Returns an array of Citizen objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Citizen
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
