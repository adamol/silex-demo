<?php

namespace Order;

class Repository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save(Model $order)
    {
        $sql = '
            INSERT INTO orders
            (email, amount, card_last_four, confirmation_number, created_at)
            VALUES
            (?, ?, ?, ?, null)
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $order->getEmail(),
            $order->getAmount(),
            $order->getCardLastFour(),
            $order->getConfirmationNumber()
        ]);

        return $this->db->lastInsertId();
    }

    public function findOrderWithBooksByConfirmationNumber($confirmationNumber)
    {
        $order = $this->findOrderByConfirmationNumber($confirmationNumber);

        $items = $this->findItemsForOrder($order);

        return new JsonableOrder($order, $items);
    }

    public function findById($orderId)
    {
        $sql = '
            SELECT email, confirmation_number, card_last_four, amount, id
            FROM orders
            WHERE id=?;
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$confirmationNumber]);

        $entry = $stmt->fetch();

        return (new Order)
            ->setEmail($entry['email'])
            ->setId($entry['id'])
            ->setConfirmationNumber($entry['confirmation_number'])
            ->setCardLastFour($entry['card_last_four'])
            ->setAmount($entry['amount']);
    }

    private function findOrderByConfirmationNumber($confirmationNumber)
    {
        $sql = '
            SELECT email, confirmation_number, card_last_four, amount, id
            FROM orders
            WHERE confirmation_number=?;
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$confirmationNumber]);

        return $stmt->fetch();
    }

    private function findItemsForOrder(array $order)
    {
        $sql = '
            SELECT books.id as book_id, books.price, books.title, count(book_items.id) as book_count
            FROM books
            JOIN book_items ON books.id=book_items.book_id
            JOIN orders ON orders.id=book_items.order_id
            WHERE orders.id=?  GROUP BY books.id;
        ';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$order['id']]);

        return $stmt->fetchAll();
    }
}
