<?php

namespace Order;

class Reservation
{
    private $email;

    private $items;

    public function __construct($email, array $items)
    {
        $this->email = $email;
        $this->items = $items;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function totalCost()
    {
        $prices = [];

        foreach ($this->items as $item) {
            $prices[] = $item->getBookPrice();
        }

        return array_sum($prices);
    }

    public function complete($order, $orderRepository, $bookItemRepository, $mailer)
    {
        $orderId = $orderRepository->save($order);

        $bookItemRepository->updateOrderIdForItems($orderId, $order->getItems());

        $mailer->send(
            $order->getEmail(),
            new Email\OrderConfirmationEmail($order)
        );
    }
}
