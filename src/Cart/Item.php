<?php

namespace Cart;

class Item
{
    private $bookId;

    private $amount;

    public function getBookId()
    {
        return $this->bookId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setBookId($value)
    {
        $this->bookId = $value;

        return $this;
    }

    public function setAmount($value)
    {
        $this->amount = $value;

        return $this;
    }

    public function toArray()
    {
        return [
            'book_id' => $this->getBookId(),
            'amount' => $this->getAmount()
        ];
    }
}
