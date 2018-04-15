<?php

namespace Order;

class Reservation
{
    private $email;

    private $items;

    public function __construct($email, Books\Item\Model ...$items)
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
}
