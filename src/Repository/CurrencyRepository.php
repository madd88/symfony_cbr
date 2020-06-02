<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    // /**
    //  * @return Currency[] Returns an array of Currency objects
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
    public function findOneBySomeField($value): ?Currency
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Фильтр по диапазону дат и ID валюты
     *
     * @param $dateFrom
     * @param $dateTo
     * @param $valuteId
     * @return array|null
     */

    public function findByFilter($dateFrom, $dateTo, $valuteId) : ?array
    {
        $query = $this->createQueryBuilder('c')
            ->where('1=1')
            ->orderBy('c.date', 'ASC');

        if ($dateFrom && $dateTo) {
            $query->andWhere('c.date >= :date_from');
            $query->andWhere('c.date <= :date_to');
            $query->setParameters(['date_from' => $dateFrom, 'date_to' => $dateTo]);
        }
        if ($valuteId) {
            $query->andWhere('c.valuteID = :valute_id');
            $query->setParameter('valute_id', $valuteId);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function deleteAll(): int
    {
        $query = $this->createQueryBuilder('t');
        $query->delete();
        return $query->getQuery()->getSingleScalarResult() ?? 0;
    }


}
