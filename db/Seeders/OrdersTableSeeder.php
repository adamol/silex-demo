<?php

namespace Seeders;

use Order\Entities\Order;
use Books\Entities\BookItem;

class OrdersTableSeeder
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function seed()
    {
        echo "seeding orders\n";
        $order = new Order;

        $order->setEmail('john@example.com');
        $order->setAmount(10000);
        $order->setCardLastFour(4242);
        $order->setConfirmationNumber('CONFIRMATIONNUMBER1234');
        $order->setCreatedAt($this->randomDate('2018-01-01', '2018-05-01'));

        echo "adding book items to order\n";
        $bookItemIds = range(1, 25);
        shuffle($bookItemIds);
        $randomIds = array_slice($bookItemIds, 0, 5);

        $bookItems = $this->entityManager
            ->getRepository(BookItem::class)
            ->findBy(['id' => $randomIds]);

        foreach ($bookItems as $item) {
            $order->addBookItem($item);
        }

        $this->entityManager->persist($order);

        $this->entityManager->flush();

        echo "done seeding orders with book items\n";
    }

    public function randomDate($startDate, $endDate)
    {
        $randomTimestamp = rand(strtotime($startDate), strtotime($endDate));

        $randomDate = date('Y-m-d', $randomTimestamp);

        return \DateTime::createFromFormat('Y-m-d', $randomDate);
    }
}
