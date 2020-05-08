<?php

namespace App\Repository;

use App\Entity\Appointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Appointment::class);

        $this->manager = $manager;
    }

    public function save(array $data) : bool
    {
        $appointmentEntity = new Appointment();

        $appointmentEntity->setEmail($data['email']);

        $appointmentEntity->setLawyerId($data['lawyerId']);

        $appointmentEntity->setCitizenId($data['citizenId']);

        $appointmentEntity->setStatus($data['status']);

        $appointmentEntity->setDurationMins($data['durationMins']);

        $appointmentEntity->setAppointmentDatetime($data['appointmentDatetime']);

        $appointmentEntity->setDate($data['date']);

        empty($data['paymentStatus']) ? true : $appointmentEntity->setPaymentStatus($data['paymentStatus']);

        empty($data['appointmentDesc']) ? true : $appointmentEntity->setAppointmentDesc(
            $data['appointmentDesc']
        );

        empty($data['appointmentTitle']) ? true : $appointmentEntity->setAppointmentTitle($data['appointmentTitle']);

        empty($data['appointmentType']) ? true : $appointmentEntity->setAppointmentType($data['appointmentType']);

        try{
            $this->manager->persist($appointmentEntity);
            $this->manager->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findAllByOffset(array $criteria) : array
    {
        return $this->createQueryBuilder('a')
            ->setMaxResults($criteria['limit'])
            ->setFirstResult($criteria['offset'])
            ->orderBy('a.' . $criteria['orderBy']['field'], $criteria['orderBy']['order'])
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Appointment[] Returns an array of Appointment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appointment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
