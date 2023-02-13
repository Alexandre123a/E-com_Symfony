<?php

namespace App\Repository;

use App\Entity\ArticleStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleStock>
 *
 * @method ArticleStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleStock[]    findAll()
 * @method ArticleStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleStock::class);
    }

    public function save(ArticleStock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArticleStock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ArticleStock[] Returns an array of ArticleStock objects
     */
    public function findByExampleField($value,$range,$order,$desc="ASC"): array
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.intitule LIKE :val')
            ->orWhere('a.description LIKE :val')
            ->setParameter('val',"%".$value."%")
            ->setMaxResults($range)
            ->orderBy($order,$desc)
        ;
        $query = $qb->getQuery();
        return $query->execute();
    }

    public function findOneBySomeField($value): ?ArticleStock
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findTenByRandom(): array
    {
        $maxIDQb = $this->createQueryBuilder('a')
            ->select('MAX(a.id)')
        ->getQuery();
        $maxID = $maxIDQb->execute();
        $returnValue = [];
        $minIDQb = $this->createQueryBuilder('a')
            ->select('MIN(a.id)')
            ->getQuery();
        $minID = $minIDQb->execute();

        for($i=0;$i < 10;$i++) {
            $idRandom= random_int($minID[0][1],$maxID[0][1]);
            $returnValue[] = $this->createQueryBuilder('b')
                ->where('b.id = :id')
                ->setParameter('id',$idRandom)
            ->getQuery()->execute();
        }
        return $returnValue;
    }
}
