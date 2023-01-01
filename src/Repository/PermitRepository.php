<?php

namespace App\Repository;

use App\Entity\Permit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Permit>
 *
 * @method Permit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permit[]    findAll()
 * @method Permit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permit::class);
    }

    public function save(Permit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Permit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
        * @return Permit[] Returns an array of Permit objects
        */
    public function findByFilter($fullname, $izin_baslangic_tarihi, $izin_bitis_tarihi): array
    {
        $entityManager = $this->getEntityManager();

        $where = [];
        if ($fullname) $where[] = "(e.ad LIKE '%".$fullname."%' OR e.soyad LIKE '%".$fullname."%' OR CONCAT(e.ad, e.soyad) LIKE '%".$fullname."%')";
        if ($izin_baslangic_tarihi && $izin_bitis_tarihi) $where[] = "(
            (p.izin_baslangic_tarihi >= '".$izin_baslangic_tarihi."' and p.izin_baslangic_tarihi <= '".$izin_bitis_tarihi."') OR
            (p.izin_baslangic_tarihi <= '".$izin_baslangic_tarihi."' and p.izin_bitis_tarihi >= '".$izin_baslangic_tarihi."')
        )";

        if (count($where) > 0) $where = "WHERE ".implode(' AND ', $where);
        else $where = "";

        $query = $entityManager->createQuery(
            "SELECT p.id, p.izin_baslangic_tarihi, p.izin_bitis_tarihi, e.ad, e.soyad
            FROM App\Entity\Permit p
            LEFT JOIN p.employee_id e
            ".$where
        )
        ->getResult();

        return $query;
    }

//    public function findOneBySomeField($value): ?Permit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
