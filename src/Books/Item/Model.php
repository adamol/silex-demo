<?php

namespace Books\Item;

class Model
{
    private $id;

    private $book;

    private $code;

    private $bookId;

    private $orderId;

    private $reservedAt;

    private $createdAt;

    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getBook()
    {
        return $this->book;
    }

    public function getBookId()
    {
        return $this->bookId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getReservedAt()
    {
        return $this->reservedAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function setBook($value)
    {
        $this->book = $value;

        return $this;
    }

    public function setBookId($value)
    {
        $this->bookId = $value;

        return $this;
    }

    public function setOrderId($value)
    {
        $this->orderId = $value;

        return $this;
    }

    public function setReservedAt($value)
    {
        $this->reservedAt = $value;

        return $this;
    }

    public function setCreatedAt($value)
    {
        $this->createdAt = $value;

        return $this;
    }

    public function setUpdatedAt($value)
    {
        $this->updatedAt = $value;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($value)
    {
        $this->code = $value;

        return $this;
    }
}
