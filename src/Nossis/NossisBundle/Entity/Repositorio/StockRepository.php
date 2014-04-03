<?php

namespace Nossis\NossisBundle\Entity\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * StockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StockRepository extends EntityRepository
{
    
    public function findLast($limit=20)
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('s')
            ->from('NossisBundle:Stock', 's')
            ->orderBy('s.id')
            ->setMaxResults($limit)
            ->getQuery();
        return $query->getResult();
        
    }
    
    
}
