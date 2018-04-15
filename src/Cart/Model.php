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

    public function append(Item\Model $item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function reserveItems($email, \Books\Item\Repository $bookItemRepository)
    {
        $reservedItems = [];

        foreach ($this->items as $item) {
            $reservedItems[] = $bookItemRepository->reserveCartItem($item);
        }

        return new Reservation($email, ...$reservedItems);
    }
}

