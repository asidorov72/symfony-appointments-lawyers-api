<?php

namespace App\Repository;

use App\Entity\Lawyer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Lawyer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lawyer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lawyer[]    findAll()
 * @method Lawyer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LawyerRepository extends ServiceEntityRepository
{
    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Lawyer::class);

        $this->manager = $manager;
    }

    public function save(array $data) : bool
    {
//        var_dump($data['lawyerDegree']);
//        die();


        $lawyerEntity = new Lawyer();

        $lawyerEntity->setPassword($data['password']);

        $lawyerEntity->setEmail($data['email']);

        $lawyerEntity->setFirstName($data['firstName']);

        $lawyerEntity->setLastName($data['lastName']);

        $lawyerEntity->setPhoneNumber($data['phoneNumber']);

        $lawyerEntity->setTitle($data['title']);

        $lawyerEntity->setDateOfBirth($data['dateOfBirth']);

        $lawyerEntity->setLawyerLicenceNumber($data['lawyerLicenseNumber']);

        $lawyerEntity->setLawyerLicenseIssueDate($data['lawyerLicenseIssueDate']);

        $lawyerEntity->setLawyerLicenseExpireDate($data['lawyerLicenseExpireDate']);

        $lawyerEntity->setTypeOfLawyer($data['typeOfLawyer']);

        $lawyerEntity->setLawyerDegree($data['lawyerDegree']);

        empty($data['postalCode']) ? true : $lawyerEntity->setPostalCode($data['postalCode']);

        empty($data['postalAddress']) ? true : $lawyerEntity->setPostalAddress($data['postalAddress']);

        empty($data['country']) ? true : $lawyerEntity->setCountry($data['country']);

        empty($data['companyName']) ? true : $lawyerEntity->setCompanyName($data['companyName']);

        empty($data['lawyerLicenseName']) ? true : $lawyerEntity->setCompanyName($data['lawyerLicenseName']);

        try{
            $this->manager->persist($lawyerEntity);
            $this->manager->flush();
            return true;
        } catch(\Exception $e) {
//            throw new \Exception('SQL query error. Probably email is duplicated.');
            throw new \Exception($e->getMessage());
        }
    }

    // /**
    //  * @return Lawyer[] Returns an array of Lawyer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lawyer
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
