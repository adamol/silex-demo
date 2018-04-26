<?php

namespace Books\Item;

class Repository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save(Model $item)
    {
        $sql = '
            INSERT INTO book_items
            (book_id, code)
            VALUES
            (?, ?)
        ';
        $stmt = $this->db->prepare($sql);

        $stmt->exec([$item->getBookId(), $item->getCode()]);

        return $this->db->lastInsertedId;
    }

    public function updateOrderIdForItems($orderId, array $items)
    {
        $listOfItemIds = implode(',', array_map(function($item) {
            return $item->getId();
        }, $items));

        $sql = "
            UPDATE book_items SET order_id = ?
            WHERE id IN ($listOfItemIds)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$orderId]);

        return $stmt->rowCount();
    }

    public function reserveCartItem(\Cart\Item $item)
    {
        $this->db->beginTransaction();

        $reservedAt = date('Y-m-d H:i:s');

        $amount = $item->getAmount();

        $updateSql = "
            UPDATE book_items SET reserved_at = '$reservedAt'
            WHERE book_id=? AND reserved_at IS NULL AND order_id IS NULL
            LIMIT $amount
        ";

        $updateStmt = $this->db->prepare($updateSql);
        $updateStmt->execute([$item->getBookId()]);

        $selectSql = "
            SELECT
                bi.id as id, bi.code as code, bi.book_id as book_id,
                bi.order_id as order_id, bi.reserved_at as reserved_at,
                bi.created_at as created_at, bi.updated_at as updated_at,
                b.price as book_price
            FROM book_items as bi
            JOIN books as b ON b.id = bi.book_id
            WHERE reserved_at = '$reservedAt' AND order_id IS NULL and book_id = ?
        ";

        $selectStmt = $this->db->prepare($selectSql);
        $selectStmt->execute([$item->getBookId()]);

        $updatedRecords = $selectStmt->fetchAll();

        if (count($updatedRecords) !== $item->getAmount()) {
            var_dump($updatedRecords);
            $this->db->rollback();

            throw new NotEnoughInventoryException(
                'There were either too few items in inventory, or they were already reserved'
            );
        }

        $this->db->commit();

        return array_map(function($entry) {
            return $this->hydrateEntry($entry);
        }, $updatedRecords);
    }

    public function hydrateEntry($entry)
    {
        return (new Model)
            ->setId($entry['id'])
            ->setCode($entry['code'])
            ->setBookId($entry['book_id'])
            ->setOrderId($entry['order_id'])
            ->setBookPrice($entry['book_price'])
            ->setReservedAt($entry['reserved_at'])
            ->setUpdatedAt($entry['updated_at'])
            ->setCreatedAt($entry['created_at']);
    }
}
