<?php

namespace Books\Item;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class Repository extends EntityRepository
{
    public function reserveCartItem(\Cart\Item $item)
    {
        $bookItems = $this->getEntityManager()->createQueryBuilder()
            ->select('bi')
            ->from('Books\Entities\BookItem', 'bi')
            ->join('Books\Entities\Book', 'b', Join::WITH, 'bi.book = b.id')
            ->where('bi.book = :bookId')
            ->andWhere('bi.reservedAt IS NULL')
            ->andWhere('bi.order IS NULL')
            ->setMaxResults($item->getAmount())
            ->setParameter('bookId', $item->getBookId())
            ->getQuery()
            ->getResult();

        $now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        foreach ($bookItems as $item) {
            $item->setReservedAt($now);
            $item->setBookPrice($item->getBook()->getPrice());
        }

        $this->getEntityManager()->flush();

        return $bookItems;
    }

    public function connectItemsToOrder($order, $items)
    {
        foreach ($items as $item) {
            $order->addBookItem($item);
        }

        $this->getEntityManager()->merge($order);

        $this->getEntityManager()->flush();
    }
}
