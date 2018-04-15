<?php

namespace Cart\Item;

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

    public function reserveCartItem(Cart\Item $item)
    {
        $this->db->beginTransaction();

        $reservedAt = date('Y-m-d H:i:s');

        $updateSql = "
            UPDATE book_items SET reserved_at = ?
            WHERE id=? AND reserved_at IS NULL AND order_id IS NULL
            LIMIT ?
        ";

        $updateStmt = $this->db->prepare($updateSql);
        $updateStmt->execute([$reservedAt, $item->getId(), $item->getAmount()]);

        $selectSql = "
            SELECT id, code, book_id, order_id, reserved_at, created_at, updated_at
            FROM book_items
            WHERE reserved_at = ? AND order_id IS NULL and book_id = ?
        ";

        $selectStmt = $this->db->prepare($updateSql);
        $selectStmt->execute([$reservedAt, $item->getId()]);

        $updatedRecords = $selectStmt->fetchAll();

        if (count($updatedRecords) !== $item->getAmount()) {
            $this->db->rollback();

            throw new \RuntimeException(
                'Something went wrong while trying to reserve items for cart'
            );
        }

        return $updatedRecords;
    }
}
