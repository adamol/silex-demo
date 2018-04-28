<?php

namespace Books\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="book_items")
 */
class BookItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

	/**
     * Many BookItems have One Book.
     * @ORM\ManyToOne(targetEntity="Books\Entities\Book", inversedBy="bookItems")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book;

    /**
     * Many BookItems have One Orders.
     * @ORM\ManyToOne(targetEntity="Order\Entities\Order", inversedBy="bookItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     **/
    private $order;

    /**
     * @ORM\Column(type="string")
     **/
    private $bookPrice;

    /**
     * @ORM\Column(type="string")
     **/
    private $code;

    /**
     * @ORM\Column(type="datetime")
     **/
    private $reservedAt;

    /**
     * @ORM\Column(type="datetime")
     **/
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     **/
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

    public function getBookPrice()
    {
        return $this->bookPrice;
    }

    public function setBookPrice($value)
    {
        $this->bookPrice = $value;

        return $this;
    }
}
