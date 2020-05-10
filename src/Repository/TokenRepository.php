<?php

namespace App\Repository;

use App\Entity\Token;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Token|null find($id, $lockMode = null, $lockVersion = null)
 * @method Token|null findOneBy(array $criteria, array $orderBy = null)
 * @method Token[]    findAll()
 * @method Token[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    public function save(array $data) : bool
    {
        $em = $this->getEntityManager();

        $tokenEntity = new Token();

        $currDate = new \DateTime("now");

        $tokenEntity->setDate($currDate);

        $tokenEntity->setUuidToken($data['uuidToken']);

        try{
            $em->persist($tokenEntity);
            $em->flush();

            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // /**
    //  * @return Token[] Returns an array of Token objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findUuidToken($value): ?Token
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.uuidToken = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAndDelete(array $data)
    {
        $em = $this->getEntityManager();

        $tokenEntity = $this->findUuidToken($data['uuidToken']);

        if (empty($tokenEntity)) {
            throw new \Exception('Token not found');
        }

        $id = $tokenEntity->getId();

        try{
            $tokenEntity = $this->find($id);
            $em->remove($tokenEntity);
            $em->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate(),
            'uuidToken' => $this->getUuidToken()
        ];
    }

}
