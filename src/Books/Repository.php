<?php

namespace Books;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityRepository;

class Repository extends EntityRepository
{
    public function findByCategories($categories)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('b')
            ->from('Books\Entities\Book', 'b')
            ->join('Categories\Entities\BookCategory', 'bc', Join::WITH, 'bc.book = b.id')
            ->join('Categories\Entities\Category', 'c', Join::WITH, 'bc.category = c.id')
            ->join('Books\Entities\BookItem', 'i', Join::WITH, 'i.book = b.id')
            ->where('c.type IN (:categories)')
            ->setParameter('categories', $categories)
            ->getQuery()
            ->getResult();
    }
}
