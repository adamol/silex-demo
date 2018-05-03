<?php

namespace Books\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Books\Item\Repository")
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
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     **/
    private $order;

    private $bookPrice;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    private $code;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     **/
    private $reservedAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     **/
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     **/
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function getBook()
    {
        return $this->book;
    }

    public function setBook($value)
    {
        $this->book = $value;

        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($value)
    {
        $this->order = $value;

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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($value)
    {
        $this->code = $value;

        return $this;
    }

    public function getReservedAt()
    {
        return $this->reservedAt;
    }

    public function setReservedAt($value)
    {
        $this->reservedAt = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($value)
    {
        $this->createdAt = $value;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($value)
    {
        $this->updatedAt = $value;

        return $this;
    }
}
