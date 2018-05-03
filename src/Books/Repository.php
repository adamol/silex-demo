<?php

namespace Books;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityRepository;

class Repository extends EntityRepository
{
    public function findByCategories($categories)
    {
        $this->getEntityManager()->createQueryBuilder()
            ->select('
                b,
                GROUP_CONCAT(DISTINCT(c.type)) as categories,
                count(DISTINCT(i.id)) as book_count
            ')
            ->from('Books\Entities\Book', 'b')
            ->join('Categories\Entities\Category', 'c', Join::WITH, 'b.categories = c.books')
            ->join('Books\Entities\BookItem', 'i', Join::WITH, 'b.book_items = i.book')
            ->where('c.type IN (:categories)')
            ->setParameter('categories', $categories)
            ->getQuery()
            ->getResult();
    }
}
