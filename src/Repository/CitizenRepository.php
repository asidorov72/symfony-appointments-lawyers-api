<?php

namespace App\Repository;

use App\Entity\Citizen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

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

    public function saveCitizen(array $data) : bool
    {
        $citizenEntity = new Citizen();

        $citizenEntity->setEmail($data['email']);

        $citizenEntity->setPassword($data['password']);

        $citizenEntity->setName($data['name']);

        empty($data['age']) ? true : $citizenEntity->setAge($data['age']);

        empty($data['phone']) ? true : $citizenEntity->setPhone($data['phone']);

        empty($data['sex']) ? true : $citizenEntity->setSex($data['sex']);

        try{
            $this->manager->persist($citizenEntity);
            $this->manager->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception('SQL query error. Probably email is duplicated.');
        }
    }

    public function findCitizen(array $criteria)
    {
        return $this->findOneBy($criteria);
    }







    public function findAllCitizen(array $criteria) : array
    {
        return $this->findAll();

        $gb = $this->createQueryBuilder('f');

//        foreach($criteria['exclude'] as $index => $word) {
//            $gb->andWhere("f.message NOT LIKE :msg$index")
//                ->setParameter("msg$index", '%' . $word . '%');
//        }

        ($criteria['limit'] === 0) ? true : $gb->setMaxResults($criteria['limit']);

        $gb->orderBy( 'f.' . $criteria['orderBy']['field'], $criteria['orderBy']['order']);

        try {
            return $gb->getQuery()
                ->getResult();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
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
