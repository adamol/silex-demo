<?php

namespace Order;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityRepository;

class Repository extends EntityRepository
{
    public function findOrderWithBooksByConfirmationNumber($confirmationNumber)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Order\Entities\Order', 'o')
            ->join('Books\Entities\BookItem', 'bi', Join::WITH, 'bi.order = o.id')
            ->join('Books\Entities\Book', 'b', Join::WITH, 'b.id = bi.book')
			->where('o.confirmationNumber = :confirmationNumber')
			->setParameter('confirmationNumber', $confirmationNumber)
            ->getQuery()
            ->getSingleResult();
    }

    public function save(\Order\Entities\Order $order)
    {
        $this->getEntityManager()->persist($order);

        $this->getEntityManager()->flush();
    }
}
