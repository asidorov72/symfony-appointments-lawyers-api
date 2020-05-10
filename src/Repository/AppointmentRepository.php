<?php

namespace App\Repository;

use App\Entity\Appointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    public function save(array $data) : bool
    {
        $em = $this->getEntityManager();

        $appointmentEntity = new Appointment();

        $currDate = new \DateTime("now");

        $appointmentEntity->setDate($currDate);

        $appointmentEntity->setLawyerId($data['lawyerId']);

        $appointmentEntity->setCitizenId($data['citizenId']);

        $appointmentEntity->setStatus($data['status']);

        $appointmentEntity->setDurationMins($data['durationMins']);

        $appointmentEntity->setAppointmentDatetime($data['appointmentDatetime']);

        empty($data['paymentStatus']) ? true : $appointmentEntity->setPaymentStatus($data['paymentStatus']);

        empty($data['appointmentDesc']) ? true : $appointmentEntity->setAppointmentDesc(
            $data['appointmentDesc']
        );

        empty($data['appointmentTitle']) ? true : $appointmentEntity->setAppointmentTitle($data['appointmentTitle']);

        empty($data['appointmentType']) ? true : $appointmentEntity->setAppointmentType($data['appointmentType']);

        try{
            $em->persist($appointmentEntity);
            $em->flush();

            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(array $data) : bool
    {
        $em = $this->getEntityManager();

        $appointmentEntity = $em->getRepository(Appointment::class)->find($data['id']);

        $currDate = new \DateTime("now");

        $appointmentEntity->setDate($currDate);

        $appointmentEntity->setLawyerId($data['lawyerId']);

        $appointmentEntity->setCitizenId($data['citizenId']);

        $appointmentEntity->setStatus($data['status']);

        $appointmentEntity->setDurationMins($data['durationMins']);

        $appointmentEntity->setAppointmentDatetime($data['appointmentDatetime']);

        empty($data['paymentStatus']) ? true : $appointmentEntity->setPaymentStatus($data['paymentStatus']);

        empty($data['appointmentDesc']) ? true : $appointmentEntity->setAppointmentDesc(
            $data['appointmentDesc']
        );

        empty($data['appointmentTitle']) ? true : $appointmentEntity->setAppointmentTitle($data['appointmentTitle']);

        empty($data['appointmentType']) ? true : $appointmentEntity->setAppointmentType($data['appointmentType']);

        try{
            $em->persist($appointmentEntity);
            $em->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateStatus(array $data) : bool
    {
        $em = $this->getEntityManager();

        $appointmentEntity = $em->getRepository(Appointment::class)->find($data['id']);

        $currDate = new \DateTime("now");

        $appointmentEntity->setDate($currDate);

        $appointmentEntity->setStatus($data['status']);

        empty($data['paymentStatus']) ? true : $appointmentEntity->setPaymentStatus($data['paymentStatus']);

        try{
            $em->persist($appointmentEntity);
            $em->flush();
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

    public function findAndDelete(array $data)
    {
        $em = $this->getEntityManager();

        try{
            $appointmentEntity = $this->find($data['id']);
            $em->remove($appointmentEntity);
            $em->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
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
