<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\ORM\Query;
use App\Entity\AdSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }


    /**
     * 
     *
     * @param AdSearch $search
     * @return Query
     */
    public function findAllVisibleQuery(AdSearch $search)
    {
        $query = $this->findVisibelQuery();
        if($search->getMinPrice()){
            $query = $query->andwhere('a.price <= :minPrice')
                           ->setParameter('minPrice',$search->getMinPrice()); 
        }

        if($search->getMaxPrice()){
            $query = $query->andwhere('a.price >= :maxPrice')
                           ->setParameter('maxPrice',$search->getMaxPrice()); 
        }  
        if($search->getCity()){
            $query = $query->andwhere('a.city = :city')
                           ->setParameter('city',$search->getCity()); 
        } 
        return $query->getQuery();     
       
    }
    

    private function findVisibelQuery():QueryBuilder
    {
        return $this->createQueryBuilder('a');
        // ->where('a.id = :id');
    }
    
}
 