<?php

namespace Cart;

use Order\Reservation;

class Model
{
    private $items;

    public function setItems(array $value)
    {
        $this->items = $value;

        return $this;
    }

    public function append(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function reserveItems($email, \Books\Item\Repository $bookItemRepository)
    {
        $reservedItems = [];

        foreach ($this->items as $item) {
            $reservedItems = array_merge(
                $reservedItems,
                $bookItemRepository->reserveCartItem($item)
            );
        }

        return new Reservation($email, $reservedItems);
    }

    public function increaseAmountForItem(Item $item, $increaseAmount)
    {
        $cartItem = $this->getItemByBookId($item->getBookId());

        $cartItem->setAmount($cartItem->getAmount() + $increaseAmount);
    }

    public function has(Item $item)
    {
        return null !== $this->getItemByBookId($item->getBookId());
    }

    private function getItemByBookId($bookId)
    {
        $result = array_filter($this->items, function($current) use ($bookId) {
            return $current->getBookId() === $bookId;
        });

        if ($result === []) {
            return null;
        }

        if (count($result) === 1) {
            return $result[0];
        }

        throw new \Exception('Multiple items found for a single id');
    }

    public function getItems()
    {
        return $this->items;
    }

    public function resetItems()
    {
        $this->items = [];
    }
}

